import pandas as pd
import numpy as np
import xlrd as xd
import time
from openpyxl import load_workbook

start_time = time.time()
var_p = "\\N"
startx = 64998
endx = 73374
path = "Blank_Template.xlsx"
df1 = pd.read_excel(path, 0,None)
path2 = "Final_Admissions.xlsx"
df2 = pd.read_excel(path2, 0,None)
error = ["\\N", "0"]

df1.columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']
dicth = {1:'C',2: 'D',3: 'E',4: 'F',5: 'G',6: 'H',7: 'I',8: 'J'}
fcollege = []
fsubjects = []
fmarks = []

for i in range(startx,endx+1):
    print(str(i*100/endx) + "% - " + str(i))
    keyx2 = df2.iloc[i]
    key2 = str(keyx2[4])
    cat = ["Unreserved", "OBC", "SC", "ST", "PwD", "Kashmiri Migrant", "Nominated By Sikkim Government",
           "Sikh Minority"]
    crs = str(keyx2[6])
    xyya = "NCWEB"
    entr = ["Bachelor of Management Studies (BMS)",
            "Bachelor of Business Administration (Financial Investment Analysis) (BBA(FIA)",
            "B.A. (Hons.) Business Economics"]
    pweb = crs.find(xyya)
    if key2 in cat and pweb==-1 and crs not in entr:
        cent1 = str(keyx2[14])
        if cent1 in error:
            cent1 = str(keyx2[10])
        if cent1 not in error:
            cent = float(cent1)
            if cent > 40:
                clg = str(keyx2[7])
                cat = cat.index(key2) + 1
                catpos = dicth[cat]
                cccx = df1.loc[df1['A'] == clg]
                ccyx = cccx.loc[cccx['B'] == crs][catpos]
                orcent = int(ccyx.iloc[0])
                xrow = ccyx.index[0]
                if cent < orcent:
                    df = pd.read_excel(path, header=None)
                    df2x = pd.DataFrame({'Data': [cent]})
                    writer = pd.ExcelWriter(path, engine='openpyxl')
                    book = load_workbook(path)
                    writer.book = book
                    writer.sheets = dict((ws.title, ws) for ws in book.worksheets)
                    df.to_excel(writer, sheet_name='Sheet1', header=None, index=False)
                    df2x.to_excel(writer, sheet_name='Sheet1', header=None, index=False,
                                  startcol=cat + 1, startrow=xrow)
                    writer.save()