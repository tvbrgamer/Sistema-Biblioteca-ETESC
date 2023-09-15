FOR /F "tokens=1-4 delims=/ " %%i in ('date/t') do set d=%%i-%%j-%%k-%%l
SET d=%d:~0,-1%

xcopy /S /E /I /Y "C:\xampp\htdocs\Sistema-Biblioteca" "C:\Users\usuario\Desktop\Backup Arquivos\Site\%d%\Sistema-Biblioteca"