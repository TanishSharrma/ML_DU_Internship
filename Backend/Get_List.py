dict = {"Hans Raj College":"N",
"Rajdhani College":"S",
"Deshbandhu College":"S",
"Shivaji College":"S",
"Mata Sundri College for Women (W)":"O",
"Satyawati College":"O",
"Sri Venketeswara College":"S",
"Hindu College":"N",
"Gargi College (W)":"O",
"Swami Shardhanand College":"O",
"Sri Guru Tegh Bahadur Khalsa College":"N",
"Motilal Nehru College":"S",
"Kirori Mal College":"N",
"Dyal Singh College (Evening)":"S",
"Deen Dayal Upadhyaya College":"O",
"Atma Ram Sanatan Dharma College":"S",
"Aryabhatta College":"S",
"Satyawati College (Evening)":"O",
"Ramjas College":"N",
"Keshav Mahavidyalaya":"O",
"Kamala Nehru College (W)":"O",
"College of Vocational Studies":"S",
"Zakir Husain Delhi College (Evening)":"O",
"Department of Germanic and Romance Studies":"O",
"Shyam Lal College (Evening)":"N",
"Lady Shri Ram College for Women (W)":"S",
"Shaheed Rajguru College of Applied Sciences for Women (W)":"O",
"Shaheed Bhagat Singh College":"S",
"Sri Aurobindo College (Evening)":"O",
"Indraprastha College for Women (W)":"N",
"Dyal Singh College":"S",
"Institute of Home Economics (W)":"O",
"Shri Ram College of Commerce":"N",
"Delhi College of Arts and Commerce":"S",
"Lady Irwin College (W)":"N",
"Shaheed Bhagat Singh College (Evening)":"S",
"P.G.D.A.V. College (Evening)":"S",
"Janki Devi Memorial College (W)":"O",
"Shyam Lal College":"N",
"Miranda House (W)":"N",
"P.G.D.A.V. College":"S",
"Acharya Narendra Dev College":"S",
"Motilal Nehru College (Evening)":"S",
"Maitreyi College (W)":"S",
"Vivekananda College (W)":"O",
"Sri Aurobindo College (Day)":"S",
"Bharati College (W)":"O",
"Zakir Husain Delhi College":"O",
"Sri Guru Gobind Singh College of Commerce":"N",
"Shyama Prasad Mukherji College For Women (W)":"O",
"Daulat Ram College (W)":"N",
"Lakshmibai College (W)":"N",
"Sri Guru Nanak Dev Khalsa College":"O",
"Maharaja Agrasen College":"N",
"Ram Lal Anand College":"S",
"Ramanujan College":"S",
"Dr. Bhim Rao Ambedkar College":"O",
"Bhaskaracharya College of Applied Sciences":"O",
"Indira Gandhi Institute of Physical Education & Sports Sciences":"O",
"Kalindi College (W)":"O",
"Cluster Innovation Centre":"O",
"Jesus & Mary College (W)":"S",
"Aditi Mahavidyalaya (W)":"O",
"Shaheed Sukhdev College Business Studies":"O",
"Bhagini Nivedita College (W)":"O",
"Delhi School of Journalism":"O"}
dictx = {"N":0, "S":1, "O":2}
dictc = {"1":1, "2":2, "3":3, "4":4, "5":5, "6":6, "7":7, "8":8, "9":9, "10":10}

import pandas as pd

path = "Final_Admissions.xlsx"

df = pd.read_excel(path, 0,None)
start = 2
end = 73375

list = [[0, 0, 0],[0, 0, 0],[0, 0, 0],[0, 0, 0],[0, 0, 0],[0, 0, 0],[0, 0, 0],[0, 0, 0],[0, 0, 0],[0, 0, 0]]
int = 1

for i in range(start,end-1):
    keyx = df.iloc[i]
    key = str(keyx[8])
    prog = (i*100)/end
    if prog > int:
        print (str(int) + " %")
        int += 1

    if key != "41" and key != "69":
        clg = str(keyx[7])
        if key[1] != "0":
            lx = str(key[0])
        else:
            lx = "10"
        camp = dict[clg]
        campx = dictx[camp]
        lxi = dictc[lx]
        tval = list[lxi-1][campx]
        list[lxi-1][campx] = tval+1

North = []
South = []
Off = []
for p in range(10):
    px = list[p]
    sum = px[0]+px[1]+px[2]
    p0 = (px[0] * 100) / sum
    p1 = (px[1] * 100) / sum
    p2 = (px[2] * 100) / sum
    North.append(p0)
    South.append(p1)
    Off.append(p2)

CO = [1,2,3,4,5,6,7,8,9,10]
title = "Percent of Admissions taken in various Campuses during respective Cut-Off Lists"
import matplotlib.pyplot as plt

plt.plot(CO,North,label="North Campus Colleges", marker='o')
plt.plot(CO,South,label="South Campus Colleges", marker='o')
plt.plot(CO,Off,label="Off Campus Colleges", marker='o')
plt.ylabel("Percentage of Students")
plt.xlabel("Cut-Off List No.")
plt.axis([0,11,0,65])
plt.legend()
plt.title(title)
plt.show()