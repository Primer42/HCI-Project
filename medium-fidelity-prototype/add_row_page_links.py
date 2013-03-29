'''
Created on Mar 29, 2013

@author: Will
'''
import os
from bs4 import BeautifulSoup
import codecs

if __name__ == '__main__':
    medFidDir = os.path.dirname(os.path.abspath(__file__))
    
    originalDir = os.path.join(medFidDir, 'original_files')
    objectDirs = [p for p in [os.path.join(originalDir, n) for n in os.listdir(originalDir)] if os.path.isdir(p)]
    for od in objectDirs:
        for fullListHTML in [os.path.join(od, '1.html'), os.path.join(od, '2.html')]:
            listSoup = BeautifulSoup(open(fullListHTML, 'r'))
            entryTable = listSoup.find_all('table')[1]
            for ridx, row in enumerate(entryTable.find_all('tr')):
                #don't modify the header row
                if ridx == 0:
                    continue
                pageColumnTag = listSoup.new_tag('td')
                pageLinkTag = listSoup.new_tag('a', href="./r" + str(ridx) + ".html")
                pageLinkTag.string = "View Details"
                pageColumnTag.append(pageLinkTag)
                row.append(pageColumnTag)
            writeListFile = codecs.open(fullListHTML, 'w')
            writeListFile.write(listSoup.prettify())
            writeListFile.close()
            
