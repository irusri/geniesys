#R Script for creating correlation values of EucGenIE experiments : Chanaka Mannapperuma : 20/01/2017
args <- commandArgs(TRUE)
input_cordinates <- strsplit(args[1],",") 
database_table_name <- args[2]
sorting_order_asc <- args[3]
number_od_results <- args[4]

#Remove warining messages
options(warn=-1)

#Load libraries
library("methods")
library("DBI")
library("reshape2")
library(RMySQL)
library(rjson)

#MySQL connection
mydb = dbConnect(MySQL(), user='popuser', password='poppass', dbname='eucgenie_egrandis_v2', host='localhost')

#MySQL Query to fetch all the expression values in given table
MySQL_Query<-paste('select id,sample,cast(log2 as decimal(11,4)) as log2 from ',database_table_name)

rs =dbSendQuery(mydb,MySQL_Query)
mysql_data = fetch(rs, n=-1)
read_expression_table <- dcast(mysql_data, id ~ sample, value.var='log2')
read_expression_table[is.na(read_expression_table)] <- 0

#Close MySQL connection
on.exit(dbDisconnect(mydb), add = TRUE)

#MySQL expression table
tmp_matrix<-as.matrix(read_expression_table[,2:ncol(read_expression_table)])
row.names(tmp_matrix)<-read_expression_table$id


#Input argument
input_data_frame<-data.frame(t(unlist(input_cordinates)))
colnames(input_data_frame) <-  colnames(read_expression_table)
input_data_matrix<-as.matrix(input_data_frame[,2:ncol(input_data_frame)])
row.names(input_data_matrix)<-"tmp"
mode(input_data_matrix) <- "numeric"


#Calculating correlation 
final_corr<- cor(t(input_data_matrix),t(tmp_matrix))

#Load libraries
cor_melted_results <-melt(final_corr, id.vars=c("gene1"),
                     variable.name="gene2",
                     value.name="corr")
colnames(cor_melted_results) <- c("gene1","gene2","corr")
cor_melted_results <-head(cor_melted_results[ order(cor_melted_results$corr, decreasing = sorting_order_asc),],number_od_results)

#Print results as JSON
#head(unname(split(cor_melted_results[,2:3],1:nrow(cor_melted_results), 2:nrow(cor_melted_results))))
output_json <- toJSON(unname(split(cor_melted_results[,2:3], 1:nrow(cor_melted_results), 2:nrow(cor_melted_results) )))
cat(output_json)


