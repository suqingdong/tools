#!/usr/bin/env python
#-*- coding: utf-8 -*-


def table_filter(infile1, infile2, column, outfile=None):
    outfile = outfile or infile1.rsplit('.',1)[0] + '.filtered.xls'

    target_list = []
    with open(infile2) as f:
        for line in f:
            target_list.append(line.strip())

    with open(infile1) as f, open(outfile, 'w') as out:
        header = f.next()
        out.write(header)
        for line in f:
            linelist = line.strip().split('\t')
            if linelist[int(column)-1] in target_list:
                out.write(line)



if __name__ == '__main__':
    import sys
    if len(sys.argv) < 4:
        print 'Usage: python %s <infile1> <infile2> <column> [outfile]' % sys.argv[0]
        exit(1)
    table_filter(*sys.argv[1:])