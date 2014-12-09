      subroutine callsub

      use parm
      use parm1


      sum1 = sum1 + 1
      id = sum1 / flg

      if (myid3 == id) then 
          call subbasin1
          hrusper = hrusper + hrutot(inum1)
          if (curyr == 1 .AND. inum1 .GE. inum1per) then
              inum1per = inum1
          end if

      endif

      if (id .GT. nprocs3 - 1) then
          if (myid3 == nprocs3 - 1) then 
              call subbasin1
              hrusper = hrusper + hrutot(inum1)
              if (curyr == 1 .AND. inum1 .GE. inum1per) then
                  inum1per = inum1
              end if
          endif
      endif 
     
      end
