import sys
import smtplib

fromaddr = sys.argv[3]
toaddrs = sys.argv[1]
subject = "SFTP CLIENT - FILE CONVERSION INFO"

msg = ("From: %s\r\nSubject: %s\r\nTo: %s\r\n\r\n"
       % (fromaddr, subject, toaddrs))

msg = msg + sys.argv[2]

server = smtplib.SMTP(sys.argv[4])
server.set_debuglevel(1)
server.sendmail(fromaddr, toaddrs, msg)
server.quit()