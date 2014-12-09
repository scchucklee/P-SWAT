      subroutine stdaa_aureduce

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

      real :: tmp_sdiegropq, tmp_sdiegrolpq, tmp_sdiegrops,             &
     &        tmp_sdiegrolps,tmp_sbactrop,tmp_sbactrolp, tmp_sbactsedp, &
     &        tmp_sbactsedlp,tmp_sbactlchp,tmp_sbactlchlp

      real A(10), B(10)

!      tmp_sdiegropq = sdiegropq
!      tmp_sdiegrolpq = sdiegrolpq
!      tmp_sdiegrops = sdiegrops
!      tmp_sdiegrolps = sdiegrolps   
!      tmp_sbactrop = sbactrop
!      tmp_sbactrolp = sbactrolp
!      tmp_sbactsedp = sbactsedp
!      tmp_sbactsedlp = sbactsedlp
!      tmp_sbactlchp = sbactlchp
!      tmp_sbactlchlp = sbactlchlp

      A(1) = sdiegropq
      A(2) = sdiegrolpq
      A(3) = sdiegrops
      A(4) = sdiegrolps
      A(5) = sbactrop
      A(6) = sbactrolp
      A(7) = sbactsedp
      A(8) = sbactsedlp
      A(9) = sbactlchp
      A(10) = sbactlchlp


!      call mpi_allreduce(tmp_sdiegropq, sdiegropq, 1, mpi_real,         &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sdiegrolpq, sdiegrolpq, 1, mpi_real,       &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sdiegrops, sdiegrops, 1, mpi_real,         &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sdiegrolps, sdiegrolps, 1, mpi_real,       &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sbactrop, sbactrop, 1, mpi_real,           &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sbactrolp, sbactrolp, 1, mpi_real,         &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sbactsedp, sbactsedp, 1, mpi_real,         &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sbactsedlp, sbactsedlp, 1, mpi_real,       &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sbactlchp, sbactlchp, 1, mpi_real,         &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sbactlchlp, sbactlchlp, 1, mpi_real,       &
!     &                   mpi_sum, mpi_comm_world, ierr)

      call mpi_allreduce(A(1), B(1), 10, mpi_real, mpi_sum,             &
     &                   subcomm, ierr)

      sdiegropq = B(1)
      sdiegrolpq = B(2)
      sdiegrops = B(3)
      sdiegrolps = B(4)
      sbactrop = B(5)
      sbactrolp = B(6)
      sbactsedp = B(7)
      sbactsedlp = B(8)
      sbactlchp = B(9)
      sbactlchlp = B(10)


      end
