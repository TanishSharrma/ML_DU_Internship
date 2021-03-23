dict = {1:'a',2:'b',3:'c',4:'d',5:'e',6:'f',7:'g',8:'h',9:'i',10:'j',11:'k',12:'l',13:'m',14:'n',15:'o',16:'p',17:'q',18:'r',19:'s',20:'t',21:'u',22:'v',23:'w',24:'x',25:'y',26:'z'}
import random
while True:
    res = ""
    for i in range(3):
        x = random.randint(1, 26)
        res += dict[x]
    f = input("No ?")
    print (res)


'''
import pandas as pd

path = "Subjects.xlsx"

df = pd.read_excel(path, 0,None)
start = 1
end = 55

list = []
filex = open("temp.txt","r+")

for i in range(start,end+1):
    keyx = df.iloc[i]
    key = str(keyx[7])
    if key not in list:
        list.append(key)

list.sort()

for iter in list:
    out = iter + "\n"
    resultString = filex.read()
    filex.write(out)

filex.close()'''