#!/usr/bin/env python
def parse(file, store):
        f = open(file, 'r')
        dic = {}
        for i in f:
                i = i.strip("\n")
                val = i.split("\t")
                try:
                        dic[val[0]] = dic[val[0]] + ";"+ val[1]+"-"+val[2]
                except KeyError:
                        dic[val[0]] = val[1]+"-"+val[2]
        f.close()
        f = open(store, 'w')
        for i in dic.keys():
                string = i+"\t"+dic[i]+"\t0"
                f.write(string+"\n")
        f.close

if __name__=="__main__":
        import sys
        if len(sys.argv) > 1:
                file = sys.argv[1]
                store = sys.argv[2]
                parse(file, store)
        else:
                sys.exit("No input")

####INPUT
#Eucgr.A00001	GO:0008565	protein transporter activity
#Eucgr.A00001	GO:0031204	posttranslational protein targeting to membrane, translocation
#Eucgr.A00004	GO:0005634	nucleus
#Eucgr.A00006	GO:0003677	DNA binding
#Eucgr.A00006	GO:0003824	catalytic activity
#Eucgr.A00012	GO:0015031	protein transport
#Eucgr.A00012	GO:0006457	protein folding
#Eucgr.A00014	GO:0003852	2-isopropylmalate synthase activity
#Eucgr.A00014	GO:0009098	leucine biosynthetic process
#Eucgr.A00017	GO:0008312	7S RNA binding

###OUTPUT
#Eucgr.L00569	GO:0004672-protein kinase activity;GO:0006468-protein phosphorylation;GO:0005524-ATP binding
#Eucgr.K00395	GO:0003723-RNA binding
#Eucgr.A02469	GO:0004672-protein kinase activity;GO:0006468-protein phosphorylation
#Eucgr.E01168	GO:0005089-Rho guanyl-nucleotide exchange factor activity
#Eucgr.A02467	GO:0007275-multicellular organismal development;GO:0005634-nucleus;GO:0006511-ubiquitin-dependent protein catabolic process
#Eucgr.E01166	GO:0016747-transferase activity, transferring acyl groups other than amino-acyl groups
#Eucgr.A02465	GO:0006950-response to stress;GO:0051087-chaperone binding;GO:0001671-ATPase activator activity
#Eucgr.A02464	GO:0006662-glycerol ether metabolic process;GO:0045454-cell redox homeostasis;GO:0015035-protein disulfide oxidoreductase activity
#Eucgr.E01163	GO:0016747-transferase activity, transferring acyl groups other than amino-acyl groups
#Eucgr.A02462	GO:0005634-nucleus;GO:0006355-regulation of transcription, DNA-templated;GO:0003677-DNA binding;GO:0003700-sequence-specific DNA binding transcription factor activity;GO:004356
