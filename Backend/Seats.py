import pandas as pd
import numpy as np

path = "admission_detail.csv"

start = 1
end = 813795

df = pd.read_csv(path)
df.columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
              'V', 'W', 'X', 'Y', 'Z', 'AA']
res = []
old = 0
temp = 1
int = 1
for i in range(start,end-1):
    keyx = df.iloc[i]
    key = str(keyx[0])
    prog = (i*100)/end
    if prog > int:
        print (str(int) + " %")
        int += 1
    if key == old:
        temp +=1
    else:

        res.append(temp)
        old = key
        temp = 1
if temp >0:
    res.append(temp)

avg = np.average(res)

print(avg)
print(len(res))
