Rscript volcano.R \
	-i test.txt \
	-o test.png \
	--title "Volcano Plot Demo" \
	--xindex 6 \
	--yindex 8 \
	--xthread 2 \
	--ythread 0.05 \
	--xmax 4 \
	--ymax 40 \
	--color "red;black;green" \
	--width 1080 \
	--height 720
