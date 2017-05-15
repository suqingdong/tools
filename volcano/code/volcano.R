suppressWarnings(library(optparse))
suppressWarnings(library(ggplot2))


# ==========================Arguments parse=================================
option_list <- list(
  make_option(c('-i', '--infile'), dest='infile', default=NULL, help='The input file.'),
  make_option(c('-o', '--outfile'), dest='outfile', default=NULL, help='The output file.'),
  make_option(c('--title'), dest='title', default='Volcano Plot', help='The input file[default="%default"].'),
  make_option(c('--xthread'), dest='xthread', default=2, type='double', help='The log2FC thread[defalut=%default].'),
  make_option(c('--ythread'), dest='ythread', default=0.05, type='double', help='The FDR(Pvalue) thread[defalut=%default].'),
  make_option(c('--xindex'), dest='xindex', default=NULL, type='integer', help='The column number of log2FC.'),
  make_option(c('--yindex'), dest='yindex', default=NULL, type='integer', help='The column number of FDR(Pvalue).'),
  make_option(c('--xmax'), dest='xmax', default=NULL, type='integer', help='The limit of X axis.'),
  make_option(c('--ymax'), dest='ymax', default=NULL, type='integer', help='The limit of Y axis.'),
  make_option(c('--color'), dest='color', default=NULL, help='The custom color str, separate by comma or semicolon.'),
  make_option(c('--width'), dest='width', default=1280, type='integer', help='The width of output file[default=%default].'),
  make_option(c('--height'), dest='height', default=960, type='integer', help='The height of output file[default=%default].')
)

parser <- OptionParser(option_list=option_list, usage='Rscript %prog [options]')
opts <- parse_args(parser)

infile <- opts$infile
outfile <- opts$outfile
title <- opts$title
xthread <- opts$xthread 
ythread <- opts$ythread 
xindex <- opts$xindex - 1
yindex <- opts$yindex - 1
xmax <- opts$xmax
ymax <- opts$ymax
color <- opts$color
width <- opts$width
height <- opts$height

# print(color)
# print(xmax)
# print(xindex)
# print(xthread)
# quit('no')
if( is.null(infile) || is.null(outfile) || is.null(xindex) || is.null(yindex) ) {
    cat('[Arguments Error]: Rscript volcano.R -h for more information.')
    quit('no')
}



# ====================read data, stringAsFactors=F is important===========================
df <- read.table(infile, sep='\t', header=T, row.names=1, stringsAsFactors=F)



# ==================add a new column for significance===================
# ======  FDR<=0.05 && |FC|>=2  => significance  yes  ======
# ==========================================================
print('Start reformatting significance...')
sig_ncol <- ncol(df)+1
for(i in 1:nrow(df)) {
  
  log2FC <- as.double(df[i, xindex])  
  FDR <- as.double(df[i, yindex])
  
  if( FDR <= ythread && log2FC >= xthread/2 ) {
    df[i, sig_ncol] <- "up"
  } else if( FDR <= ythread && log2FC <= -xthread/2 ) {
    df[i, sig_ncol] <- "down"
  } else {
    df[i, sig_ncol] <- "normal"
  }
}
print('End reformatting significance...')

# ====================update colnames=============================
colnames(df)[sig_ncol] <- 'significance'


# =========================draw points==========================================
p <- ggplot(df, aes(x=log2FC, y=-log10(FDR), color=significance)) + geom_point()


# =========================custom colors========================================
if( ! is.null(color) ) {
  color <- unlist(strsplit(color, ',|;'))     #unlist to vector
  p <- p + scale_color_manual(values = color)
}


#==========================add lines=============================================
p <- p + geom_vline(xintercept=c(-xthread/2, xthread/2), linetype="longdash", size=0.2)
p <- p + geom_hline(yintercept=c(-log10(ythread)), linetype="longdash", size=0.2)


# ========================custom axis limits=====================================
if ( ! is.null(xmax) ) {
  p <- p + xlim(-xmax, xmax)
}

if ( ! is.null(ymax) ) {
  p <- p + ylim(NA, ymax)
}



# =========================add title=============================================
p <- p + labs(title=title)


# =========================change themes=========================================
p <- p + theme_bw()
p <- p + theme(
  axis.text = element_text(size=18),
  axis.title = element_text(size=22),
  legend.title = element_blank(),
  legend.text = element_text(size=18),
  plot.title = element_text(size=24, hjust=0.5),
  panel.border = element_blank(),
  panel.grid = element_blank()
)



# ========================Save image==========================
png(outfile, height=height, width=width, type='cairo')
p
dev.off()

