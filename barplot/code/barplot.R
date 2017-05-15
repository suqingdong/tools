suppressWarnings(library(optparse))
suppressWarnings(library(ggplot2))
suppressWarnings(library(reshape2))


option_list = list(
  make_option(c('-i', '--infile'), default=NULL, help='The input file.'),
  make_option(c('-o', '--outfile'), default=NULL, help='The output file.'),
  make_option(c('--title'), default='BarPlot', help='The title of the picture.'),
  make_option(c('--xlab'), default='X', help='The xlab of the picture.'),
  make_option(c('--ylab'), default='Y', help='The ylab of the picture.'),
  make_option(c('--width'), default=1280, type='integer', help='The width of the picture.'),
  make_option(c('--height'), default=720, type='integer', help='The height of the picture.'),
  make_option(c('--position'), default='stack', help='The position of bar["stack", "dodge" default="%default"]')
)

parser <- OptionParser(option_list=option_list, epilogue='\tContact: suqingdong@novogene.com\n')
opts <- parse_args(parser)


infile <- opts$infile
outfile <- opts$outfile
title <- opts$title
xlab <- opts$xlab
ylab <- opts$ylab
width <- opts$width
height <- opts$height
position <- opts$position


if ( is.null(infile) || is.null(outfile) ) {
  cat('Usage: Rscript piechart.R -h for more help infomation\n')
  quit('no')
}

library(ggplot2)
library(reshape2)
 
d <- read.table(infile, header = T, row.names = 1)
mtd <- melt(t(d))
 
png(outfile, type = 'cairo', width = width, height = height)
 
p <- ggplot(mtd, aes(Var2, value, fill = Var1)) +
  geom_bar(stat = 'identity', position = position) +
  labs(x = xlab, y = ylab, title = title)

p <- p + theme(
  plot.title = element_text(size=24, hjust=0.5),
  panel.border = element_blank(),
  panel.grid = element_blank(),
  legend.title = element_blank()
)

p

dev.off()
