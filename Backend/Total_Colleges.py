import pandas as pd

path = "Final_Admissions.xlsx"

df = pd.read_excel(path, 0,None)
start = 2
end = 73375

int = 1
list = []
for i in range(start,end-1):
    keyx = df.iloc[i]
    key = str(keyx[7])
    prog = (i*100)/end
    if prog > int:
        print (str(int) + " %")
        int += 1
    if key not in list:
        list.append(key)
    if i==end-1:
        print("100 %")
filex = open("temp.txt","r+")
resultString = filex.read()
out = ""
i = 1
for x in list:
    out += str(i) + "\t" + str(x) + "\n"
    i+=1
filex.write(out)
filex.close()