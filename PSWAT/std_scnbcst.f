      subroutine std_scnbcst

      use parm
      use parm1
      include 'mpif.h'

      integer :: sumnrot = 0
      integer :: psumnrot = 0
      integer :: lenbcast

!      allocate(alenbcast(nprocs))
!      allocate(apsumnrot(nprocs))
!      allocate(ahruscan(nprocs))
!      allocate(ahrusper(nprocs))
!      allocate(subtotga(nprocs))
     
      call mpi_scan(hrusper, hruscan, 1, mpi_integer, mpi_sum,          &
     &              subcomm, ierr) 

      do j = hruscan - hrusper + 1, hruscan
         sumnrot = sumnrot + nrot(j)
      end do

      if (myid3 == 0) then
         psumnrot = 0
      else
         do j = 1, hruscan - hrusper
            psumnrot = psumnrot + nrot(j)
         end do
      end if

      lenbcast =  sumnrot * mcr * 2

      call mpi_allgather(lenbcast, 1 ,mpi_integer, alenbcast, 1,        &
     &                   mpi_integer, subcomm, ierr)
      call mpi_allgather(psumnrot, 1 ,mpi_integer, apsumnrot, 1,        &
     &                   mpi_integer, subcomm, ierr)

      do j = 0, nprocs3 - 1
          call mpi_bcast(yldn(1,1,apsumnrot(j+1)+1 ),alenbcast(j + 1),  &
     &                     mpi_real, j, subcomm,ierr) 

          call mpi_bcast(bio_aahv(1,1,apsumnrot(j+1)+1), alenbcast(j+1),&
     &                     mpi_real, j, subcomm,ierr) 

!         call mpi_barrier(mpi_comm_world, ierr)

      end do      

      end
