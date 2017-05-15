args <- commandArgs()
if ( length(args)<7 ) {
    print('Usage: Rscript heatmap.R <infile> <outfile>')
    quit()
}
infile <- args[6]
outfile <- args[7]

library(ggplot2)
library(reshape2)

file<-read.table(file=infile,header=T,sep="\t")
md<-melt(file,id=c("GeneName"))
md$color[md$value<0.0001] <- "0-0.0001"
md$color[md$value<0.001 & md$value >=0.0001] <- "0.0001-0.001"
md$color[md$value < 0.01 & md$value >= 0.001] <- "0.001-0.01"
md$color[md$value<0.1 & md$value >= 0.01] <- "0.01-0.1"
md$color[md$value<0.5 & md$value >= 0.1] <- "0.1-0.5"
md$color[md$value<2 & md$value >= 0.5] <- "No_Frequency"
md$color[md$value>=2] <- "No_Variation"
png(outfile, type='cairo-png', width=800, height=1200, res=72*2)
p<-ggplot(md,aes(y=GeneName,x=variable,fill=color))
cb_palette <- c("#80b1d3","#b3de69","#bebada","#ffffb3","#fccde5","#fb8072","#d9d9d9")
p <- p + scale_fill_manual(values=cb_palette)
p<-p + geom_tile(color="white",size=0.1)+
theme(axis.text.y=element_text(size=8,face="bold"),axis.text.x=element_text(size=8,face="bold",angle=45,h=0.8))+
labs(title='Frequency Distribution
',x='Samples',y='Varition
')+
theme(axis.title.x=element_text(size=12),axis.title.y=element_text(size=12),plot.title=element_text(size=14,))
p
dev.off()
