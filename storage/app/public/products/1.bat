@echo off
for /d %B in(C:\Users\Vadim\Downloads\products\*) do (
for %C in ("%B*\.jpeg") do echo %C)