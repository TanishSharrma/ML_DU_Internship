import pandas as pd

path = "academic_detail.csv"

start = 1
end = 813795

df = pd.read_csv(path)
df.columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
              'V', 'W', 'X', 'Y', 'Z', 'AA']
filex = open("temp.txt","r+")

int = 1
for i in range(start,end-1):
    keyx = df.iloc[i]
    key = str(keyx[5])
    prog = (i*100)/end
    if prog > int:
        print (str(int) + " %")
        int += 1
    if key == "Payment Done":
        out = ""
        for x in range(27):
            out += str(keyx[x]) + "\t"
        out += "\n"
        resultString = filex.read()
        filex.write(out)

filex.close()
