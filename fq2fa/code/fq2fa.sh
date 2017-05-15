infile=$1
outfile=$2
yasuo=$3

fq2fa="/usr/local/software/fastx_toolkit/fastq_to_fasta"


if [ ${infile##*.} == 'gz' ];then
    echo gz file
    zcat $infile | $fq2fa -Q 33 -o $outfile $3
else
    echo not gz file
    $fq2fa -Q 33 -i $infile -o $outfile $3
fi