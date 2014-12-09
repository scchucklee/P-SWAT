#!/bin/bash
#./serial | grep BEST
#mpirun -np 10 ./ga2 | grep G
#bsub -W 00:15 -n 10 -q x64_3950dbg -o %J.out -e %J.err mpijob.openmpi /home_soft/soft/x86_64/apps/PSWAT/pswat 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 0.2 10 /home_soft/home/scliqiang/ xinjiang.out

mpirun -np 2 ./kriging 0.5 72 0.7 12 0.3 0.4 6 0.015 768 49 3.2 9.7 8.3 7.6 4.8 11.5 13.9 21.7 6.2 0.7 37 0.2 10 /home/liqiang/data/AutoCal/ xinjiang.out 
