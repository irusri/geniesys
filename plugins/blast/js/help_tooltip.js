$(document).ready(function() 
{
	help()
});

function help()
{
	/*
	OVERARCHING HELP TOOLTIPS THAT MAY BE USED ON SEVERAL PAGES
	*/
	$("button#gid_help").qtip({
		content: 'Type in query seqence which should match to the selected Blast program<br/>\n'
		,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
			}
		},
		style: {
			width: 300,
			padding: 5,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	
	
		$("button#gid_help_dna").qtip({
		content: 'You can input  multiple sequences at once if they are in fasta format (where each sequence has a header line that starts with > and contains the name of the sequence.'
		,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
			}
		},
		style: {
			width: 500,
			padding: 5,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	
	
	$("button#data_type_help_main").qtip({
		content: 'Populus Blast'
			,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
				
			}
		},
		style: {
			width: 300,
			padding: 2,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
		$("button#select_blat_db_help").qtip({
		content: 'Select one Blat dataset.'
			,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
				
			}
		},
		style: {
			width: 300,
			padding: 2,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	
			$("button#select_blat_sort_help").qtip({
		content: 'Sort the results by given options.'
			,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
				
			}
		},
		style: {
			width: 300,
			padding: 2,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	
	
			$("button#select_blat_format_help").qtip({
		content: 'Select appropriate format for display results.'
			,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
				
			}
		},
		style: {
			width: 300,
			padding: 2,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	
	
	$("button#gid_help_upload").qtip({
		content: 'Sequences should be in FASTA format'
			,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
			}
		},
		style: {
			width: 300,
			padding: 2,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
		$("button#gid_help_selectdb").qtip({
		content: 'Select at least one blast dataset(s)'
			,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
			}
		},
		style: {
			width: 300,
			padding: 2,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	
			$("button#gid_help_advanced").qtip({
		content: 'Advanced optional search parameters.'
			,
		position: {
			corner: {
				target: 'leftBottom',
				tooltip: 'rightBottom',
			}
		},
		style: {
			width: 300,
			padding: 2,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	
	$("button#data_type_help").qtip({
		content: 'Select the appropriate blast program'
			,
		position: {
			corner: {
					target: 'leftBottom',
				tooltip: 'rightBottom',
			}
		},
		style: {
			width: 300,
			padding: 5,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	
		$("button#data_type_help_blatblast").qtip({
		content: 'Select either BLAST or BLAT program'
			,
		position: {
			corner: {
					target: 'leftBottom',
				tooltip: 'rightBottom',
			}
		},
		style: {
			width: 300,
			padding: 5,
			background: '#93d39a',
			color: '#000000',
			border: {
				width: 2,
				radius: 3,
				color: '#CBE8BD'
			},
			tip: 'rightMiddle'
		},
	});
	

}
