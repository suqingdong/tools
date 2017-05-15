suppressWarnings(library(optparse))

suppressWarnings(library(ggplot2))
suppressWarnings(library(reshape2))

suppressWarnings(library(ggrepel))


# ============================Argument Parse=====================================================
option_list = list(
  make_option(c('-i', '--infile'), default=NULL, help='The input file.'),
  make_option(c('-o', '--outfile'), default=NULL, help='The output file.'),
  make_option(c('-t', '--title'), default='PieChart', help='The main title[default "%default"].')
)

parser <- OptionParser(option_list=option_list, epilogue='\tContact: suqingdong@novogene.com\n')
opts <- parse_args(parser)

infile <- opts$infile
outfile <- opts$outfile
title <- opts$title

if ( is.null(infile) || is.null(outfile) ) {
  cat('Usage:\n\tRscript piechart.R -h for more help infomation\n')
  quit('no')
}


# =====================melt data================================
d <- read.table(infile, sep='\t', header=T, row.names=1)
d <- d[order(d, decreasing=T)]

md <- melt(d)

# =====================draw barplot=====================
p <- ggplot(md, aes(x=factor(1), y=value, fill=variable))
p <- p + geom_bar(stat='identity', width=1)


# =====================convert to pie=====================
p <- p + coord_polar(theta='y')


# =================change theme(remove axis and legend title)==============
p <- p + theme_bw() + theme(
  axis.title = element_blank(),
  axis.text = element_blank(), 
  axis.ticks = element_blank(),
  legend.title = element_blank(),
  legend.text = element_text(size=14),
  panel.border = element_blank(),
  panel.grid = element_blank()
)


# =====================add label text============================================
label_value <- paste('(', round(md$value/sum(md$value) * 100, 1), '%)', sep = '')
label <- paste(md$variable, label_value, sep=' ')
p <- p + geom_text(
  label = label,
  check_overlap = T,
  size = 5
)

p <- p + scale_fill_discrete(labels=label)


# =====================add annotation(title)=============================
p <- p + annotate("text", label=title, x=2, y=10, size=8)



# ===============save image=====================
png(outfile, height=720, width=1280, type='cairo')
p
dev.off()

 



# geom_text(aes(y = md$value/2 + c(0, cumsum(md$value)[-length(md$value)]), x = sum(md$value)/150, label = label))
