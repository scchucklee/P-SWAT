!!    This program's name is P-SWAT. 
!!    This is the parallel version of SWAT(Soil and Water Assessment Tool).
!!    Copyright (C) <2014>  <Chuck Lee, Computer Network Information Center, Chinese Academy of Sciences>

!!    This program is free software: you can redistribute it and/or modify
!!    it under the terms of the GNU General Public License as published by
!!    the Free Software Foundation, either version 3 of the License, or
!!    (at your option) any later version.

!!    This program is distributed in the hope that it will be useful,
!!    but WITHOUT ANY WARRANTY; without even the implied warranty of
!!    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
!!    GNU General Public License for more details.

!!    You should have received a copy of the GNU General Public License
!!    along with this program.  If not, see <http://www.gnu.org/licenses/>.
      program main
!!    this is the main program that reads input, calls the main simulation
!!    model, and writes output.
!!    comment changes to test merging with trunk and c:\branch_test code
!!    two lines added to c:\branch_test code

!!    ~ ~ ~ INCOMING VARIABLES ~ ~ ~
!!    name        |units         |definition
!!         ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 
!!    date        |NA            |date simulation is performed where leftmost
!!                               |eight characters are set to a value of
!!                               |yyyymmdd, where yyyy is the year, mm is the 
!!                               |month and dd is the day
!!    isproj      |none          |special project code:
!!                               |1 test rewind (run simulation twice)
!!    time        |NA            |time simulation is performed where leftmost
!!                               |ten characters are set to a value of
!!                               |hhmmss.sss, where hh is the hour, mm is the 
!!                               |minutes and ss.sss is the seconds and
!!                               |milliseconds
!!    values(1)   |year          |year simulation is performed
!!    values(2)   |month         |month simulation is performed
!!    values(3)   |day           |day in month simulation is performed
!!    values(4)   |minutes       |time difference with respect to Coordinated
!!                               |Universal Time (ie Greenwich Mean Time)
!!    values(5)   |hour          |hour simulation is performed
!!    values(6)   |minutes       |minute simulation is performed
!!    values(7)   |seconds       |second simulation is performed
!!    values(8)   |milliseconds  |millisecond simulation is performed
!!    zone        |NA            |time difference with respect to Coordinated
!!                               |Universal Time (ie Greenwich Mean Time)
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 

!!    ~ ~ ~ OUTGOING VARIABLES ~ ~ ~
!!    name        |units         |definition
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 
!!    prog        |NA            |program name and version
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 

!!    ~ ~ ~ LOCAL DEFINITIONS ~ ~ ~
!!    name        |units         |definition
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 
!!    i           |none          |counter
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 


!!    ~ ~ ~ SUBROUTINES/FUNCTIONS CALLED ~ ~ ~
!!    Intrinsic: date_and_time
!!    SWAT: getallo, allocate_parms, readfile, readfig
!!    SWAT: readbsn, std1, readwwq, readinpt, std2, storeinitial
!!    SWAT: openwth, headout, simulate, finalbal, writeaa, pestw 

!!    ~ ~ ~ ~ ~ ~ END SPECIFICATIONS ~ ~ ~ ~ ~ ~

      use parm
      use parm1
      implicit none
      include 'mpif.h'

      integer :: ierr

!      integer :: narg
!      character(len=5) :: arg(23),brg
!      integer b(23)
       narg=IARGC()
       do i=1,25
          call getarg(i,arg(i))
       end do
       read(arg,*) brg
       read(arg(23),*) crg
!       write(*,*) 'brg=',brg,crg
!       write(*,*) 'arg=',arg(24),arg(25)
!       write(*,*) 'arg24=',adjustr(arg(24))
!       write(*,*) 'arg25=',arg(25)
       erg = adjustl(adjustr(arg(24))//adjustl(arg(25)))
       write(*,*) 'erg=',erg
!      real*8 :: time1, time2
      prog = "SWAT  Sept '05 VERSION2005"

      write (*,1000)
 1000 format(1x,"               SWAT2005               ",/,             &
     &          "      Soil & Water Assessment Tool    ",/,             &
!     &          "              UNIX Version            ",/,             &
     &          "               PC Version             ",/,             &
     &          " Program reading from file.cio . . . executing",/)

!! process input
      call mpi_init(ierr)
      call mpi_comm_size(mpi_comm_world, nprocs, ierr)
      call mpi_comm_rank(mpi_comm_world, myid, ierr)
!      write(*,*) 'myid=',myid,'nprocs=',nprocs
      time1 = mpi_wtime()
      time3 = time1
      myid1 = myid
      nprocs1 = nprocs
      write(*,*) 'nprocs=',nprocs,'myid=',myid
      call getallo
      call allocate_parms
      call readfile
      call readbsn
      call readwwq
      if (fcstyr > 0 .and. fcstday > 0) call readfcst
      call readplant             !! read in the landuse/landcover database
      call readtill              !! read in the tillage database
      call readpest              !! read in the pesticide database
      call readfert              !! read in the fertilizer/nutrient database
      call readurban             !! read in the urban land types database
      call readfig
      call readatmodep
      call readinpt
      call std1
      call std2
      call openwth
      call headout
      wshdaaoo = wshdaao(1)
      if (isproj == 2) then 
        hi_targ = 0.0
      end if

!! save initial values
      if (isproj == 1) then
        scenario = 2
        call storeinitial
      else if (fcstcycles > 1) then
        scenario =  fcstcycles
        call storeinitial
      else
        scenario = 1
      endif

        if (iclb /= 4) then
      do iscen = 1, scenario
!      write(*,*) 'brgg=',brg 
        !! simulate watershed processes
        call simulate

        !! perform summary calculations
        call finalbal
        call writeaa
        call pestw
       
        !!reinitialize for new scenario
        if (scenario > iscen) call rewind_init
      end do
         end if

      do i = 1, 9
        close (i)
      end do 

!      call mpi_barrier(mpi_comm_world, ierr)

      write (*,1001)

 1001 format (/," Execution successfully completed ")
	
        allocation = 0
        iscen=1
        if (iclb > 0) call automet
	
      time2=mpi_wtime()
      write (*,*) 'Total time is',time2 - time1,'s'
         stop
      call mpi_finalize(ierr)
      end
