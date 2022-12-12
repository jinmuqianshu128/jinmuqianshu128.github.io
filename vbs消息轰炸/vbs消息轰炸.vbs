Set WshShell=WScript.CreateObject("WScript.Shell")
WshShell.AppActivate"傻鸟"
for i=1 to 150
WScript.Sleep 1
WshShell.SendKeys"^v"
WshShell.SendKeys i
WshShell.SendKeys"%s"
Next