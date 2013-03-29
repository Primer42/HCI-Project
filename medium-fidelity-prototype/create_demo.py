'''
Created on Mar 28, 2013

@author: will
'''
import os
import itertools
from shutil import copyfile
import re

def mkdir(path):
    if not os.path.exists(path):
        os.makedirs(path)


if __name__ == '__main__':
    medFidDir = os.path.dirname(os.path.abspath(__file__))
    
    #get our directory paths, make sure they exist and whatnot
    demoDir = os.path.join(medFidDir, 'demo')
    mkdir(demoDir)
    
    originalDir = os.path.join(medFidDir, 'original_files')
    if not os.path.exists(originalDir):
        exit("Original file directory does not exist: %s" % originalDir)
        
    #get our object names, and make sure we have all the files we need
    objNames = sorted(d for d in os.listdir(originalDir) if os.path.isdir(os.path.join(originalDir, d)))
    shortNames = dict(zip(objNames, [n[0] for n in objNames]))
    if not len(shortNames.values()) == len(set(shortNames.values())):
        exit("Two objects have the same first character! %s" % str(objNames))
    
    for o in objNames:
        for f in ['1.html', '2.html', 'add.html']:
            curFile = os.path.join(originalDir, o, f)
            if not os.path.exists(curFile):
                exit("Missing file: %s" % curFile)
    
    
    for l in xrange(len(objNames)+1):
        for objs in itertools.combinations(objNames, l):
            curDir = ''.join([shortNames[n] for n in objs])
            curPath = os.path.join(demoDir, curDir if len(curDir) > 0 else "START")
            
            mkdir(curPath)
            
            for o in objNames:
                #do the list file for this object
                curObjPath = os.path.join(curPath, o + '.html')
                if o in objs:
                    copyfile(os.path.join(originalDir, o, '2.html'), 
                             curObjPath)
                else:
                    copyfile(os.path.join(originalDir, o, '1.html'),
                             curObjPath)
                #now, do the add file
                #a bit more complicated, because we need to adjust the 'save' link to the correct other location
                curAddPath = os.path.join(curPath, 'add_' + o + '.html')
                addStr = open(os.path.join(originalDir, o, 'add.html')).read()
                if o in objs:
                    #simple case - no complicated redirection necessary
                    #just go to our local o
                    addStr = re.sub('ACTIONGOESHERE', 
                                    os.path.join('.', o + '.html'), 
                                    addStr)
                else:
                    dirWithOAdded = ''.join(sorted(curDir + shortNames[o]))
                    addStr = re.sub('ACTIONGOESHERE',
                                    os.path.join('..', dirWithOAdded, o + '.html'),
                                    addStr)
                addFile = open(curAddPath, 'w')
                addFile.write(addStr)
                addFile.close()