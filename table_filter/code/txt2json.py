#!/usr/bin/env python
# -*- coding: utf-8 -*-

import json
from collections import defaultdict

def txt2json(infile, outfile=None):
    outfile = outfile or infile.rsplit('.',1)[0]+'.json'
    json_dict = defaultdict(list)
    with open(infile) as f:
        header = f.next().strip().split('\t')
        json_dict['header'] = header
        for line in f:
            line = line.strip().split('\t')
            json_dict['data'].append(line)
    with open(outfile, 'w') as out:
        json.dump(json_dict, out)
    # print json_dict


if __name__ == '__main__':
    import sys
    if len(sys.argv) < 2:
        print 'Usage python %s <infile> [outfile]' % sys.argv[0]
        exit(1)
    txt2json(*sys.argv[1:])
