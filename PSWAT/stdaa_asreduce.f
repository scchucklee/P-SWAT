      subroutine stdaa_asreduce

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

      real :: wstrs, tstrs, nstrs, pstrs, A(4), B(4)

!      wstrs = wshd_wstrs 
!      tstrs = wshd_tstrs
!      nstrs = wshd_nstrs
!      pstrs = wshd_pstrs

      A(1) = wshd_wstrs 
      A(2) = wshd_tstrs
      A(3) = wshd_nstrs
      A(4) = wshd_pstrs


!      call mpi_allreduce(wstrs, wshd_wstrs, 1, mpi_real, mpi_sum,       &
!     &                   mpi_comm_world, ierr)
!      call mpi_allreduce(tstrs, wshd_tstrs, 1, mpi_real, mpi_sum,       &
!     &                   mpi_comm_world, ierr)
!      call mpi_allreduce(nstrs, wshd_nstrs, 1, mpi_real, mpi_sum,       &
!     &                   mpi_comm_world, ierr)
!      call mpi_allreduce(pstrs, wshd_pstrs, 1, mpi_real, mpi_sum,       &
!     &                   mpi_comm_world, ierr)


      call mpi_allreduce(A(1), B(1), 4, mpi_real, mpi_sum,              &
     &                   subcomm, ierr)

      wshd_wstrs = B(1)
      wshd_tstrs = B(2)
      wshd_nstrs = B(3)
      wshd_pstrs = B(4)

      end
