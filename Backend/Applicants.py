dictc = {"1":1, "2":2, "3":3, "4":4, "5":5, "6":6, "7":7, "8":8, "9":9, "10":10}

import pandas as pd

path = "Final_Admissions.xlsx"

df = pd.read_excel(path, 0,None)
start = 2
end = 73375

list = [0,0,0,0,0,0,0,0,0,0]
intx = 1

for i in range(start,end-1):
    keyx = df.iloc[i]
    prog = (i*100)/end
    if prog > intx:
        print (str(intx) + " %")
        intx += 1

    if key != "41" and key != "69":
        if key[1] != "0":
            lx = str(key[0])
        else:
            lx = "10"
        lxi = dictc[lx]
        tval = list[lxi-1]
        list[lxi-1] = tval+1

CO = [1,2,3,4,5,6,7,8,9,10]
title = "Admissions Taken Per List"
import matplotlib.pyplot as plt

plt.plot(CO,list,label="Applicants", marker='o')
plt.ylabel("No. Of Students")
plt.xlabel("Cut-Off List No.")
plt.axis([0,11,0,12500])
plt.legend()
plt.title(title)
plt.show()

