      subroutine varoute_reduce

      use parm
      use parm1
      include 'mpif.h'

      integer :: mid

      if(curyr == 1 .AND. i == 1) then                             
         call mpi_allgather(inum1, 1, mpi_integer, lastsubarr, 1,       &
     &                      mpi_integer, subcomm, ierr) 
!      write (*,*) 'subbeginarr=',subbeginarr

         if (myid3 == 0) then
             subbegin = 1
             subamount = lastsubarr(myid3 + 1) * mvaro
!        else if (myid == nprocs -1) then
!             subbegin = subbeginarr(myid) + 1
!             subamount = mvaro - subbeginarr(myid)
         else
             subbegin = lastsubarr(myid3) + 1
             subamount = (lastsubarr(myid3 + 1)-lastsubarr(myid3)) *    &
     &                    mvaro             
         endif  

         call mpi_allgather(subbegin,1,mpi_integer,subbeginarr,1,       &
     &                   mpi_integer,subcomm,ierr)
         call mpi_allgather(subamount,1,mpi_integer,subamountarr,1,     &
     &                   mpi_integer,subcomm,ierr)

!      write(*,*) 'CPU',myid,subbeginarr,subamountarr

      endif  


           
      do mid = 0, nprocs3 - 1
       call mpi_bcast(varoute(1,subbeginarr(mid+1)),subamountarr(mid+1),&
     &                mpi_real,mid, subcomm,ierr)
      enddo

      do mid = 0, nprocs3 - 1
       call mpi_bcast(sub_pet(subbeginarr(mid+1)),
     &                subamountarr(mid+1)/mvaro, mpi_real, mid,         &
     &                subcomm,ierr)
      enddo
!      if(myid == 1) then
!            write(*,*),'CPU:',myid,varoute
!         do jj=1,mhyd
!            do j=1,mvaro
!               write(*,*) j,jj,varoute(j,jj)
!            enddo
!         enddo
!      endif
!      if (flagr == 0) then
!         if (curyr == 1 .AND. i == 24) then
!            do ihout = 1, 26
!              write (*,*) 'CPU:',myid,varoute(2,ihout),j,ihout
!            end do
!         end if
!          varoutf = varoute
!          call mpi_barrier(mpi_comm_world, ierr)
!          call mpi_allreduce(varoutf(1,1), varoute(1,1), size(varoutf), &
!     &                       mpi_real, mpi_sum, mpi_comm_world, ierr)
!         if (curyr == 1 .AND. i == 25) then
!             write (*,*) 'CPU:',myid,'varoute(2,1)=',varoute(2,1)
!         end if
!      flagr = 1
!      end if
      end
