      subroutine create_files(str, file_num)

      use parm1

      character(len=30) str, str1, str2, num
      integer file_num

      str1 = str(1:(index(trim(adjustl(str)),'.')-1))
      str2 = str((index(trim(adjustl(str)),'.')+1):                     &
     &           len(trim(adjustl(str))))

      write(num,*) myid1

      open(file_num,file=trim(str1)//trim(adjustl(num))//               &
     &     '.'//trim(str2))

      end
