import pandas as pd
import numpy as np
import xlrd as xd
import time
from openpyxl import load_workbook

startx = 700
endx = 784
path = "Result.xlsx"
df = pd.read_excel(path, 0,None)
out = ""

for m in range(startx,endx):
    keyx = df.iloc[m]
    a1 = "'" + str(keyx[0]) + "',"
    a2 = "'" + str(keyx[1]) + "',"
    a3 = "'" + str(keyx[2]) + "',"
    a4 = "'" + str(keyx[3]) + "',"
    a5 = "'" + str(keyx[4]) + "',"
    a6 = "'" + str(keyx[5]) + "',"
    a7 = "'" + str(keyx[6]) + "',"
    a8 = "'" + str(keyx[7]) + "',"
    a9 = "'" + str(keyx[8]) + "',"
    a10 = "'" + str(keyx[8]) + "'"

    out += "("+a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+ "), "

filex = open("temp.txt","r+")
resultString = filex.read()
out = out[:-2]
filex.write(out)
filex.close()