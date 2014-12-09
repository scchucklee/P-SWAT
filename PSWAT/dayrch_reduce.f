      subroutine dayrch_reduce

!!    ~ ~ ~ PURPOSE ~ ~ ~
!!    this subroutine performs reduction for every core into core zero

!!    ~ ~ ~ INCOMING VARIABLES ~ ~ ~
!!    name         |units         |definition
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
!!    fimp(:)      |fraction      |fraction of HRU area that is
!!                                |impervious (both directly and
!!                                |indirectly connected)
!!    hru_km(:)    |km^2          |area of HRU in square kilometers
!!    ihru         |none          |HRU number
!!    ireg(:)      |none          |precipitation category:
!!                                |  1 precipitation <= 508 mm/yr
!!                                |  2 precipitation > 508 and <= 1016 mm/yr
!!                                |  3 precipitation > 1016 mm/yr
!!    k            |none          |identification code for regression data
!!                                |  1 carbonaceous oxygen demand
!!                                |  2 suspended solid load
!!                                |  3 total nitrogen
!!                                |  4 total phosphorus
!!    precipday    |mm H2O        |precipitation for the day in HRU
!!    urblu(:)     |none          |urban land type identification number from
!!                                |urban database
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

!!    ~ ~ ~ OUTGOING VARIABLES ~ ~ ~
!!    name         |units         |definition
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
!!    regres       |kg            |amount of constituent removed in surface
!!                                |runoff
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

!!    ~ ~ ~ LOCAL DEFINITIONS ~ ~ ~
!!    name         |units         |definition
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
!!    bcod(:,:)    |none          |regression coefficients for calculating
!!                                |carbonaceous oxygen demand of urban runoff
!!    bsus(:,:)    |none          |regression coefficients for calculating
!!                                |suspended solid load of urban runoff
!!    btn(:,:)     |none          |regression coefficients for calculating
!!                                |total nitrogen in urban runoff
!!    btp(:,:)     |none          |regression coefficients for calculating
!!                                |total phosphorus in urban runoff
!!    ii           |none          |precipitation category
!!    j            |none          |HRU number
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

!!    ~ ~ ~ ~ ~ ~ END SPECIFICATIONS ~ ~ ~ ~ ~ ~


      use parm
      use parm1
      include 'mpif.h'

      integer :: totbegin, totdur, j

      call mpi_allgather(inum1per, 1, mpi_integer, subtotga, 1,         &
     &                   mpi_integer, subcomm, ierr)

      if (myid3 == 0) then
         totbegin = 1
         totdur = subtotga(myid3 + 1) * 54
      else
         totbegin = subtotga(myid3) + 1
         totdur = (subtotga(myid3 + 1) - subtotga(myid3)) * 54
      end if

      call mpi_allgather(totbegin, 1, mpi_integer, altotbegin, 1,       &
     &                   mpi_integer, subcomm, ierr)
      call mpi_allgather(totdur, 1, mpi_integer, altotdur, 1,           &
     &                   mpi_integer, subcomm, ierr)
!      write (*,*) 'CPU',myid,altotbegin,altotdur
      
      do j = 0, nprocs3 - 1
         call mpi_bcast(rchdy(1, altotbegin(j + 1)), altotdur(j + 1),   &
     &                  mpi_real, j, subcomm, ierr)
      end do

      end
