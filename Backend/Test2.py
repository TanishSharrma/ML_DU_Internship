import pandas as pd

path = "pd.xlsx"
df = pd.read_excel(path, 0, None)
start = 1
end = 50 #337369

print("Loaded " + path)

path2 = "qvc.xlsx"
df2 = pd.read_excel(path2, 0,None)
df2.columns = ['A', 'B', 'C']

print("Loaded " + path2)


int = 1
out = ""
for i in range(start, end - 1):
    keyx = df.iloc[i]
    formno = str(keyx[0])

    cccx = df2.loc[df2['A'] == formno]
    print (cccx)






def sortthis():
    path = "pd.xlsx"

    df = pd.read_excel(path, 0, None)
    start = 1
    end = 337369
    mx = ['Executive', 'Business', 'Professional', 'Private Sector', 'Proprietorship']
    inc = ["Up to 5,00,000", "Up to 6,00,000", "Up to 7,00,000", "Up to 8,00,000", "More than 8,00,000"]
    int = 1
    out = ""
    for i in range(start, end - 1):
        keyx = df.iloc[i]
        name = str(keyx[0])
        mail = str(keyx[1])
        fi = str(keyx[2])
        key = str(keyx[3])
        prog = (i * 100) / end
        if prog > int:
            print(str(int) + " %")
            int += 1

        if key in mx or fi in inc:
            out += name + "\t" + mail + "\t" + fi + "\t" + key + "\n"

    filex = open("temp.txt", "r+")
    resultString = filex.read()
    filex.write(out)
    filex.close()