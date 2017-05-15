args <- commandArgs()

if(length(args)<6) {
  cat('Usage: Rscript chisq.R <infile>')
  quit('no')
}

infile <- args[6]


d <- read.table(infile, header=T, row.names=1)
Tmin <- min(d)
N <- sum(d)


if ( Tmin>=5 && N>=40 ) {
    cat('Chisqure Test\n')
    cat(chisq.test(d)$p.value)
} else if ( Tmin<5 || N<40 ) {
    cat('Fisher Test\n')
    cat(fisher.test(d)$p.value)
}




