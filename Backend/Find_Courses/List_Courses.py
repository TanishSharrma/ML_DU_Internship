import pandas as pd
import numpy as np
import xlrd as xd
import time
start_time = time.time()
var_p = "\\N"
start = 2
end = 73374
path = "Final_Admissions.xlsx"
df = pd.read_excel(path, 0,None)
clg = []
adm = 0
intx = 1
print ("Collecting list of colleges : ")
for i in range(start,end-1):
    keyx = df.iloc[i]
    key = str(keyx[7])
    prog = (i*100)/end
    if prog > intx:
        print ("Process 1/3 : " + str(intx) + " %")
        intx += 1
    if key not in clg:
        clg.append(key)
clg.sort()
print("100 %")
cat = ["Unreserved", "OBC", "SC", "ST", "PwD", "Kashmiri Migrant", "Nominated By Sikkim Government", "Sikh Minority"]
catout = ["UR", "OBC", "SC", "ST", "PwD", "KM", "SG", "SM"]
clgcat = []
print ("Collecting list of categories per college : ")
for p in range(len(clg)):
    tempcat = []
    cc = clg[p]
    print ("Process 2/3 : " + str((p*100)/len(clg)) + " %")
    out = [0,0,0,0,0,0,0,0]
    for i in range(start, end - 1):
        keyx = df.iloc[i]
        key = str(keyx[7])
        if key == cc:
            cat1 = str(keyx[3])
            cat2 = str(keyx[4])
            if cat1==cat[0] and cat2==cat[0]:
                out[0]=1
            elif cat1==cat[1]:
                out[1]=1
            elif cat1==cat[2]:
                out[2]=1
            elif cat1==cat[3]:
                out[3]=1
            elif cat1==cat[0] and cat2==cat[4]:
                out[4]=1
            elif cat1==cat[0] and cat2==cat[5]:
                out[5]=1
            elif cat1==cat[0] and cat2==cat[6]:
                out[6]=1
            elif cat1==cat[0] and cat2==cat[7]:
                out[7]=1
    clgcat.append(out)
print("Creating " + str(len(clg)) + " Tables for every college : ")

print("Inserting Tables")
filex = open("temp.txt","r+")
finalcat = ""
for m in range(8):
    if m != 7:
        finalcat += catout[m] + "\t"
    else:
        finalcat += catout[m] + "\n"

heading = "College\tSubjects\t"+finalcat
resultString = filex.read()
filex.write(heading)

for cp in range(len(clg)):
    print("Process 3/3 : " + str((cp * 100) / len(clg)) + " %")
    catlist = clgcat[cp]
    college_name = str(clg[cp])

    subjects = []
    for i in range(start, end - 1):
        keyx = df.iloc[i]
        key = str(keyx[7])
        if key == college_name:
            crs = str(keyx[6])
            xyya = "NCWEB"
            entr = ["Bachelor of Management Studies (BMS)",
                    "Bachelor of Business Administration (Financial Investment Analysis) (BBA(FIA)",
                    "B.A. (Hons.) Business Economics"]
            pweb = crs.find(xyya)
            if crs not in subjects and pweb==-1 and crs not in entr:
                subjects.append(crs)
    subjects.sort()

    marks = ""
    for mxx in range(8):
        if mxx!=7:
            valxq = catlist[mxx] * 100
            marks+=str(valxq) + "\t"
        else:
            valxq = catlist[mxx] * 100
            marks+=str(valxq) + "\n"


    for x in range(len(subjects)):
        subj = subjects[x] + "\t"
        sql = college_name + "\t" + subj + marks
        resultString = filex.read()
        filex.write(sql)

filex.close()
print("Process Completed in : %s" % (time.time() - start_time))