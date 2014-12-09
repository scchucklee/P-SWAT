      subroutine stdaa_reduce

      use parm
      use parm1
      include 'mpif.h'


      call mpi_allgather(hruscan, 1, mpi_integer, ahruscan, 1,          &
     &                mpi_integer, subcomm, ierr)

      call mpi_allgather(hrusper, 1, mpi_integer, ahrusper, 1,          &
     &                mpi_integer, subcomm, ierr)

      do j = 0, nprocs - 1
         call mpi_bcast(hruaao(1, ahruscan(j+1) - ahrusper(j+1) + 1),   &
     &                  70 * ahrusper(j + 1), mpi_real, j,              &
     &                  subcomm, ierr)
         call mpi_bcast(bio_aams(ahruscan(j+1) - ahrusper(j+1) + 1),
     &                  ahrusper(j + 1), mpi_real, j,                   &
     &                  subcomm, ierr)
         call mpi_bcast(yldaa(ahruscan(j+1) - ahrusper(j+1) + 1), 
     &                  ahrusper(j + 1), mpi_real, j,                   &
     &                  subcomm, ierr)
      end do

      end
