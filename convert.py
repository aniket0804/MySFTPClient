import pandas as pd
import csv
import sys

df = pd.read_csv(sys.argv[1])
F = open(sys.argv[2],'w')
F.write("\"Phone\",\"FirstName\",\"LastName\"\n")
for i in df.index:
	if str(df['MOBILE'][i]) != "nan" and str(df['NAME']) != "nan":
		F.write("\"" + str(df['MOBILE'][i]) + "\",\"" + df['NAME'][i].split(' ')[0] + "\",\"" + " ".join(df['NAME'][i].split(' ')[1:]) + "\"\n")

import smtplib

fromaddr = sys.argv[6]
toaddrs = sys.argv[3]
subject = "SFTP CLIENT - FILE CONVERSION INFO - JOB ID " + sys.argv[5] 

msg = ("From: %s\r\nSubject: %s\r\nTo: %s\r\n\r\n"
       % (fromaddr, subject, toaddrs))

msg = msg + sys.argv[4] + '\n' + "Download File Path : " + sys.argv[2].replace('/var/www/html/',sys.argv[8])

server = smtplib.SMTP(sys.argv[7])
server.set_debuglevel(1)
server.sendmail(fromaddr, toaddrs, msg)
server.quit()