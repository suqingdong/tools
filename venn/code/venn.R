library(VennDiagram)


args <- commandArgs()
if( length(args) < 6 ) {
    print('Usage Rscript venn.R <infile> [outfile]')
    quit()
}

infile <- args[6]
outfile <- args[7]
if( is.na(outfile) ){
    outfile = paste( unlist(strsplit(infile, '[.]'))[1], '.png', sep='' )
}

data <- read.table(infile, header=T, sep='\t')

venn.diagram(
  x=as.list(data), 
  filename=outfile,
  height=1000,
  width=1000,
  fill=rainbow(length(data)), 
  imagetype='png',
  margin=0.2,
  resolution = 150,
)
