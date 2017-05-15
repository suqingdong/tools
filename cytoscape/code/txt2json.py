#!/usr/bin/env python

import json
from collections import defaultdict

elements = defaultdict(list)

def txt2json(infile, outfile):
  try:
    with open(infile) as f:
      for line in f:
        if 'source' in line:
          linelist = line.strip().lower().split('\t')
          source_index = linelist.index('source')
          target_index = linelist.index('target')
          line_type_index = linelist.index('type')
          continue
        linelist = line.strip().split('\t')
        source = linelist[source_index]
        target = linelist[target_index]
        line_type = linelist[line_type_index]
        elements['edges'].append({'data':{'source':source, 'target':target, 'type':line_type}})

        if {'data':{'id':source, 'type':'source'}} not in elements['nodes']:
            elements['nodes'].append({'data':{'id':source, 'type':'source'}})

        if {'data':{'id':target, 'type':'target'}} not in elements['nodes']:
            elements['nodes'].append({'data':{'id':target, 'type':'target'}})

    with open(outfile, 'w') as out:
      json.dump(elements, out, indent=2)

  except Exception as e:
    return -1

  return 0



if __name__ == '__main__':
  import sys
  if len(sys.argv) < 3:
      print('Usage: python %s <infile> <outfile>' % sys.argv[0])
      exit(1)
  print txt2json(*sys.argv[1:])
