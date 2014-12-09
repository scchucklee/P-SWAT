      subroutine lasthruarray

      use parm
      use parm1
      include 'mpif.h'

      lasthruper = 0                                            !
      if(myid3 == nprocs3 - 1) then                               !
         lasthruper = nhru                                      !  liqiang
      else                                                      !
         do isub = 1, (myid3 + 1) * flg                           !
!           write(*,*) ' hrutot:', hrutot                       !
           lasthruper = lasthruper + hrutot(isub)               !
         enddo                                                   !
      endif                                                     !
!         write(*,*) 'CPU:', myid3, 'lasthruper=', lasthruper  

      call mpi_allgather(lasthruper, 1, mpi_integer, totlasthruper, 1,  &
     &                   mpi_integer, subcomm, ierr)

!      write(*,*)'CPU',myid,'totlasthruper(',myid,')',totlasthruper
!      write(*,*)'CPU',myid,'subnum(',myid,')', inum1

      end
