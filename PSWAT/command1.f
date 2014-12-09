      subroutine command1
      
!!    ~ ~ ~ PURPOSE ~ ~ ~
!!    for every day of simulation, this subroutine steps through the command
!!    lines in the watershed configuration (.fig) file. Depending on the 
!!    command code on the .fig file line, a command loop is accessed

!!    ~ ~ ~ INCOMING VARIABLES ~ ~ ~
!!    name        |units         |definition
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 
!!    icodes(:)   |none          |routing command code:
!!                               |0 = finish       9 = save
!!                               |1 = subbasin    10 = recday
!!                               |2 = route       11 = reccnst
!!                               |3 = routres     12 = structure
!!                               |4 = transfer    13 = 
!!                               |5 = add         14 = saveconc
!!                               |6 = rechour     15 = 
!!                               |7 = recmon      16 = autocal
!!                               |8 = recyear
!!    ihouts(:)   |none          |For ICODES equal to
!!                               |0: not used
!!                               |1,2,3,5,7,8,10,11: hydrograph storage
!!                               |                     location number
!!                               |4: water source type
!!                               |   (1=reach)
!!                               |   (2=reservoir)
!!                               |9: hydrograph storage location of data to
!!                               |   be printed to event file
!!                               |14:hydrograph storage location of data to
!!                               |   be printed to saveconc file
!!    inum1s(:)   |none          |For ICODES equal to
!!                               |0: not used
!!                               |1: subbasin number
!!                               |2: reach number
!!                               |3: reservoir number
!!                               |4: reach or res # flow is diverted from
!!                               |5: hydrograph storage location of 1st
!!                               |   dataset to be added
!!                               |7,8,9,10,11,14: file number
!!    inum2s(:)   |none          |For ICODES equal to
!!                               |0,1,7,8,10,11: not used
!!                               |2,3: inflow hydrograph storage location
!!                               |4: destination type
!!                               |   (1=reach)
!!                               |   (2=reservoir)
!!                               |5: hydrograph storage location of 2nd
!!                               |   dataset to be added
!!                               |9,14:print frequency
!!                               |   (0=daily)
!!                               |   (1=hourly)
!!    inum3s(:)   |none          |For ICODES equal to
!!                               |0,1,5,7,8,10,11: not used
!!                               |2,3: subbasin number
!!                               |4: destination number. Reach or
!!                               |   reservoir receiving water
!!                               |9: print format
!!                               |   (0=normal, fixed format)
!!                               |   (1=txt format for AV interface,recday)
!!    inum4s(:)   |none          |For ICODES equal to
!!                               |0,2,3,5,7,8,9,10,11: not used
!!                               |1: GIS code printed to output file
!!                               |   (optional)
!!                               |4: rule code governing transfer of water
!!                               |   (1=fraction transferred out)
!!                               |   (2=min volume or flow left)
!!                               |   (3=exact amount transferred)
!!    mhyd        |none          |maximum number of hydrographs
!!    rnum1s(:)   |none          |For ICODES equal to
!!                               |0,1,3,5,9: not used
!!                               |2: fraction of overland flow
!!                               |4: amount of water transferred (as
!!                               |   defined by INUM4S)
!!                               |7,8,10,11: drainage area in square kilometers
!!                               |   associated with the record file
!!                               |12: rearation coefficient
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 

!!    ~ ~ ~ OUTGOING VARIABLES ~ ~ ~
!!    name        |units         |definition
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 
!!    icode       |none          |variable to hold value for icodes(:)
!!    ihout       |none          |variable to hold value for ihouts(:)
!!    inum1       |none          |variable to hold value for inum1s(:)
!!    inum2       |none          |variable to hold value for inum2s(:)
!!    inum3       |none          |variable to hold value for inum3s(:)
!!    inum4       |none          |variable to hold value for inum4s(:)
!!    rnum1       |none          |variable to hold value for rnum1s(:)
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 

!!    ~ ~ ~ LOCAL DEFINITIONS ~ ~ ~
!!    name        |units         |definition
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 
!!    idum        |none          |counter
!!    ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ 

!!    ~ ~ ~ SUBROUTINES/FUNCTIONS CALLED ~ ~ ~
!!    SWAT: subbasin, route, routres, transfer, addh, recmon
!!    SWAT: recepic, save, recday, recyear

!!    ~ ~ ~ ~ ~ ~ END SPECIFICATIONS ~ ~ ~ ~ ~ ~

      use parm
      use parm1 
!      include 'mpif.h'

      integer :: idum, isub
!      integer :: flg = 0

!      write (*,*) 'subtot=', subtot
      flg = subtot / nprocs3                                        
      hrusper = 0                                                  
      sum1 = -1                                                    
                                                                   
      if(curyr == 1 .AND. i == 1) then         
         call lasthruarray                             !liqiang
      endif                                                        

      do idum = 1, mhyd
        icode = 0
        ihout = 0
        inum1 = 0
        inum2 = 0
        inum3 = 0
        rnum1 = 0.
        inum4 = 0
        icode = icodes(idum)
        ihout = ihouts(idum)
        inum1 = inum1s(idum)
        inum2 = inum2s(idum)
        inum3 = inum3s(idum)
        rnum1 = rnum1s(idum)
        inum4 = inum4s(idum)
        inum5 = inum5s(idum)
!        if(myid==0) then
!         if(idum == mhyd) then
!           do jj=1,mhyd
!              do j=1,mvaro
!                 write(*,*) j,jj,varoute(j,jj)
!              enddo
!           enddo
!         endif
!        endif                  
        select case (icode)
          case (0)
            return
          case (1)
!            call subbasin
             call callsub                !! liqiang
          case (2) 
!            call varoute_reduce          !! liqiang
            call route
            do ivar = 1, 6
             shyd(ivar,ihout) = shyd(ivar,ihout) + varoute(ivar+1,ihout)
            end do
            shyd(7,ihout) = shyd(7,ihout) + varoute(11,ihout)
            shyd(8,ihout) = shyd(8,ihout) + varoute(12,ihout)
          case (3) 
            call routres
            do ivar = 1, 6
             shyd(ivar,ihout) = shyd(ivar,ihout) + varoute(ivar+1,ihout)
            end do
            shyd(7,ihout) = shyd(7,ihout) + varoute(11,ihout)
            shyd(8,ihout) = shyd(8,ihout) + varoute(12,ihout)
          case (4) 
            call transfer
          case (5) 
            call addh
            do ivar = 1, 6
             shyd(ivar,ihout) = shyd(ivar,ihout) + varoute(ivar+1,ihout)
            end do
            shyd(7,ihout) = shyd(7,ihout) + varoute(11,ihout)
            shyd(8,ihout) = shyd(8,ihout) + varoute(12,ihout)
          case (6) 
            call rechour
            do ivar = 1, 6
             shyd(ivar,ihout) = shyd(ivar,ihout) + varoute(ivar+1,ihout)
            end do
            shyd(7,ihout) = shyd(7,ihout) + varoute(11,ihout)
            shyd(8,ihout) = shyd(8,ihout) + varoute(12,ihout)
          case (7) 
            call recmon
            do ivar = 1, 6
             shyd(ivar,ihout) = shyd(ivar,ihout) + varoute(ivar+1,ihout)
            end do
            shyd(7,ihout) = shyd(7,ihout) + varoute(11,ihout)
            shyd(8,ihout) = shyd(8,ihout) + varoute(12,ihout)
          case (8) 
            call recyear
            do ivar = 1, 6
             shyd(ivar,ihout) = shyd(ivar,ihout) + varoute(ivar+1,ihout)
            end do
            shyd(7,ihout) = shyd(7,ihout) + varoute(11,ihout)
            shyd(8,ihout) = shyd(8,ihout) + varoute(12,ihout)
          case (9) 
            call save
          case (10) 
            call recday
            do ivar = 1, 6
             shyd(ivar,ihout) = shyd(ivar,ihout) + varoute(ivar+1,ihout)
            end do
            shyd(7,ihout) = shyd(7,ihout) + varoute(11,ihout)
            shyd(8,ihout) = shyd(8,ihout) + varoute(12,ihout)
          case (11) 
            call reccnst
            do ivar = 1, 6
             shyd(ivar,ihout) = shyd(ivar,ihout) + varoute(ivar+1,ihout)
            end do
            shyd(7,ihout) = shyd(7,ihout) + varoute(11,ihout)
            shyd(8,ihout) = shyd(8,ihout) + varoute(12,ihout)
          case (12)
            call structure
          case (13) 
            call apex_day
          case (14)
            call saveconc
          case (16)
            call autocal
        end select

      end do

      return
      end
