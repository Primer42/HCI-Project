'''
Created on Mar 29, 2013

@author: Will
'''
import os
from bs4 import BeautifulSoup
import codecs

rowPageTemplate = '''<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Tufts University</title>
</head>
<body>

<table border="3">

</table>

<button onclick="history.go(-1);return true;">Go Back</button>

</body>
</html>
'''




if __name__ == '__main__':
    medFidDir = os.path.dirname(os.path.abspath(__file__))
    
    originalDir = os.path.join(medFidDir, 'original_files')
    objectDirs = [p for p in [os.path.join(originalDir, n) for n in os.listdir(originalDir)] if os.path.isdir(p)]
    for od in objectDirs:
        fullListHTML = os.path.join(od, '2.html')
        listSoup = BeautifulSoup(open(fullListHTML, 'r'))
        entryTable = listSoup.find_all('table')[1]
        for ridx, row in enumerate(entryTable.find_all('tr')):
            if ridx == 0:
                #grab the headers
                headers = [th.text for th in row.find_all('th')]
            else:
                pageSoup = BeautifulSoup(rowPageTemplate)
                pageTable = pageSoup.table
                for header, entry in zip(headers, [td.text for td in row.find_all('td')]):
                    rowTag = pageSoup.new_tag('tr')
                    
                    
                    headerTag = pageSoup.new_tag('th')
                    headerTag.string = header
                    rowTag.append(headerTag)
                    
                    entryTag = pageSoup.new_tag('td')
                    entryTag.string = entry
                    rowTag.append(entryTag)
                    
                    pageTable.append(rowTag)
                #save the page
                pageFile = codecs.open(os.path.join(od, 'r' + str(ridx) + '.html'), 'w')
                pageFile.write(pageSoup.prettify())
                pageFile.close()
