import pandas as pd

path = "Final_Admissions.xlsx"

df = pd.read_excel(path, 0,None)
start = 2
end = 73375


intx = 1
list = []
for i in range(start,end-1):
    keyx = df.iloc[i]
    key = str(keyx[24]) #26-Sports, 24-ECA
    prog = (i*100)/end
    if prog > intx:
        print (str(intx) + " %")
        intx += 1
    keyxx = df.iloc[3]
    keyxq = str(keyxx[26])
    if key != keyxq:
        keyp = str(keyx[10])
        list.append(keyp)
    if i==end-1:
        print("100 %")

print(list)