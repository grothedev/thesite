import json
import requests
import sqlite3
import sys

def processCatalog(catalog, b):

    for i in range(0, len(catalog)):
        for j in range(0, len(catalog[i]['threads'])):
            if not 'com' in catalog[i]['threads'][j]:
                continue
            url = "https://boards.4channel.org/"+b+"/thread/"+str(catalog[i]['threads'][j]['no'])
            if wod.lower() in catalog[i]['threads'][j]['com'].lower():
                results.append(url)
            if not 'last_replies' in catalog[i]['threads'][j]:
                continue
            for k in range(0, len(catalog[i]['threads'][j]['last_replies'])):
                r = catalog[i]['threads'][j]['last_replies'][k]
                if not 'com' in r:
                        continue
                if wod.lower() in r['com'].lower():
                    results.append(url+"#p"+str(catalog[i]['threads'][j]['last_replies'][k]['no']))

bods = ['a', 'c', 'w', 'm', 'cgl', 'cm', 'f', 'n', 'jp', 'vp', 'v', 'vg', 'vr', 'co', 'g', 'tv', 'k', 'o', 'an', 'tg', 'sp', 'asp', 'sci', 'int', 'out', 'toy', 'biz', 'i', 'po', 'p', 'ck', 'ic', 'wg', 'mu', 'fa', '3', 'gd', 'diy', 'wsg', 's', 'trv', 'fit', 'x', 'lit', 'adv', 'lgbt', 'mlp', 'b', 'r', 'r9k', 'pol', 'soc', 's4s']
abods = ['hc', 'hm', 'h', 'e', 'u', 'd', 'y', 't', 'hr', 'gif']


#####################################################################


if len(sys.argv) < 2:
    print('you must provide a search word')
    sys.exit(0)

wod = sys.argv[1] #the search keyword
bod = ''
if len(sys.argv) > 2:
    bod = sys.argv[2] #the board if interest, if given

results = [] #URLs of threads which contain the keyword

if bod == '':
    print('searching all boards')
    for b in bods:
        res = requests.get("https://a.4cdn.org/"+b+"/catalog.json")
        processCatalog(json.loads(res.text), b)
else:
    print('searching board ' + bod)
    res = requests.get("https://a.4cdn.org/"+bod+"/catalog.json")
    processCatalog(json.loads(res.text), bod)


for url in results:
    print(url)
