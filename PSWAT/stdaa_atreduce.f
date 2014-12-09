      subroutine stdaa_atreduce

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

      double precision :: pup, pal, pas, plch, ftotn, ftotp, fixn1,     &
     &                    dnit, hmn1, rwn1, hmp1, rmn2, raino3,         &
     &                    tmp_basno3i, tmp_basno3f, tmp_basorgni,       &
     &                    tmp_basorgnf, tmp_basminpi, tmp_basminpf,     &
     &                    tmp_basorgpi, tmp_basorgpf, fno3, fnh3,       &
     &                    forgn1, fminp1, forgp1, yldn1, yldp, voln,    &
     &                    nitn, tmp_sno3up, rmp1
      double precision A(32), B(32)

      A(1) = wshd_plch
      A(2) = wshd_pup
      A(3) = wshd_pal
      A(4) = wshd_pas
      A(5) = wshd_ftotn
      A(6) = wshd_ftotp
      A(7) = wshd_fixn
      A(8) = wshd_dnit
      A(9) = wshd_hmn
      A(10) = wshd_rwn
      A(11) = wshd_hmp
      A(12) = wshd_rmn
      A(13) = wshd_rmp
      A(14) = wshd_raino3
!      A(15) = basno3i
      A(15) = 0
      A(16) = basno3f
!      A(17) = basorgni
      A(17) = 0
      A(18) = basorgnf
!      A(19) = basminpi
      A(19) = 0
      A(20) = basminpf
!      A(21) = basorgpi
      A(21) = 0
      A(22) = basorgpf
      A(23) = wshd_fno3
      A(24) = wshd_fnh3
      A(25) = wshd_forgn
      A(26) = wshd_fminp
      A(27) = wshd_forgp
      A(28) = wshd_yldn
      A(29) = wshd_yldp
      A(30) = wshd_voln
      A(31) = wshd_nitn
      A(32) = sno3up

!      plch = wshd_plch 
!      pup = wshd_pup
!      pal = wshd_pal
!      pas = wshd_pas
!      ftotn = wshd_ftotn
!      ftotp = wshd_ftotp
!      fixn1 = wshd_fixn
!      dnit = wshd_dnit
!      hmn1 = wshd_hmn
!      rwn1 = wshd_rwn
!      hmp1 = wshd_hmp
!      rmn2 = wshd_rmn
!      rmp1 = wshd_rmp
!      raino3 = wshd_raino3
!      tmp_basno3i = basno3i
!      tmp_basno3f = basno3f
!      tmp_basorgni = basorgni
!      tmp_basorgnf = basorgnf
!      tmp_basminpi = basminpi
!      tmp_basminpf = basminpf
!      tmp_basorgpi = basorgpi
!      tmp_basorgpf = basorgpf
!      fno3 = wshd_fno3
!      fnh3 = wshd_fnh3
!      forgn1 = wshd_forgn
!      fminp1 = wshd_fminp
!      forgp1 = wshd_forgp
!      yldn1 = wshd_yldn
!      yldp = wshd_yldp
!      voln = wshd_voln
!      nitn = wshd_nitn
!      tmp_sno3up = sno3up



!     call mpi_allreduce(plsh, wshd_plch, 1, mpi_double_precision,      &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(pup, wshd_pup, 1, mpi_double_precision,        &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(pal, wshd_pal, 1, mpi_double_precision,        &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(pas, wshd_pas, 1, mpi_double_precision,        &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(ftotn, wshd_ftotn, 1, mpi_double_precision,    &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(ftotp, wshd_ftotp, 1, mpi_double_precision,    &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(fixn1, wshd_fixn, 1, mpi_double_precision,     &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(dnit, wshd_dnit, 1, mpi_double_precision,      &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(hmn1, wshd_hmn, 1, mpi_double_precision,       &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(rwn1, wshd_rwn, 1, mpi_double_precision,       &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(hmp1, wshd_hmp, 1, mpi_double_precision,       &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(rmn2, wshd_rmn, 1, mpi_double_precision,       &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(rmp1, wshd_rmp, 1, mpi_double_precision,       &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(raino3, wshd_raino3, 1, mpi_double_precision,  &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_basno3i, basno3i, 1, mpi_double_precision, &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_basno3f, basno3f, 1, mpi_double_precision, &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_basorgni, basorgni,1, mpi_double_precision,&
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_basorgnf, basorgnf,1, mpi_double_precision,&
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_basminpi, basminpi,1, mpi_double_precision,&
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_basminpf, basminpf,1, mpi_double_precision,&
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_basorgpi, basorgpi,1, mpi_double_precision,&
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_basorgpf, basorgpf,1, mpi_double_precision,&
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(fno3, wshd_fno3, 1, mpi_double_precision,      &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(fnh3, wshd_fnh3, 1, mpi_double_precision,      &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(forgn1, wshd_forgn, 1, mpi_double_precision,   &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(fminp1, wshd_fminp, 1, mpi_double_precision,   &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(forgp1, wshd_forgp, 1, mpi_double_precision,   &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(yldn1, wshd_yldn, 1, mpi_double_precision,     &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(yldp, wshd_yldp, 1, mpi_double_precision,      &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(voln, wshd_voln, 1, mpi_double_precision,      &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(nitn, wshd_nitn, 1, mpi_double_precision,      &
!     &                   mpi_sum, mpi_comm_world, ierr)
!      call mpi_allreduce(tmp_sno3up, sno3up, 1, mpi_double_precision,   &
!     &                   mpi_sum, mpi_comm_world, ierr)
!
      call mpi_allreduce(A(1), B(1), 32, mpi_double_precision,          &
     &                   mpi_sum, subcomm, ierr)

      wshd_plch = B(1)
      wshd_pup = B(2)
      wshd_pal = B(3)
      wshd_pas = B(4)
      wshd_ftotn = B(5)
      wshd_ftotp = B(6)
      wshd_fixn = B(7)
      wshd_dnit = B(8)
      wshd_hmn = B(9)
      wshd_rwn = B(10)
      wshd_hmp = B(11)
      wshd_rmn = B(12)
      wshd_rmp = B(13)
      wshd_raino3 = B(14)
!      basno3i = B(15)
      basno3f = B(16)
!      basorgni = B(17)
      basorgnf = B(18)
!      basminpi = B(19)
      basminpf = B(20)
!      basorgpi = B(21)
      basorgpf = B(22)
      wshd_fno3 = B(23)
      wshd_fnh3 = B(24)
      wshd_forgn = B(25)
      wshd_fminp = B(26)
      wshd_forgp = B(27)
      wshd_yldn = B(28)
      wshd_yldp = B(29)
      wshd_voln = B(30)
      wshd_nitn = B(31)
      sno3up = B(32)

      end

