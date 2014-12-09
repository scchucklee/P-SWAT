      subroutine parasolopt(nopt,iobj,isens, npt,icd,ngs,npg,nps,nspl,
     *	maxn,kstop,pcento,iseed,igoc,icalml,iiname, bbound,
     * iinr, inrhru, icalpar, sensw, isenspar,
     * bestf, imet,omin,nobs,varval,iprob,istat)

c
c  SHUFFLED COMPLEX EVOLUTION METHOD FOR GLOBAL OPTIMIZATION
c     -- Version 2.2
c
c  by QINGYUN DUAN
c  National Weather Service, NOAA
c  GCIP Climate Project
c  1325 East-West Highway
c  Silver Spring, MD 20910
c  (301) 713-1018, email: qduan@smtpgate.ssmc.noaa.gov
c
c  WRITTEN IN OCTOBER 1990.
c  REVISED IN AUGUST 1991
c  REVISED IN APRIL 1992
c
c  ADAPTED BY ANN VAN GRIENSVEN IN APRIL 2003
c                 University of California, Riverside
c
c  STATEMENT BY AUTHOR:
c  --------------------
c
c     This general purpose global optimization program is developed at
c     the Department of Hydrology & Water Resources of the University
c     of Arizona.  Further information regarding the SCE-UA method can
c     be obtained from Dr. Q. Duan, Dr. S. Sorooshian or Dr. V.K. Gupta
c     at the address and phone number listed above.  We request all
c     users of this program make proper reference to the paper entitled
c     'Effective and Efficient Global Optimization for Conceptual
c     Rainfall-runoff Models' by Duan, Q., S. Sorooshian, and V.K. Gupta,
c     Water Resources Research, Vol 28(4), pp.1015-1031, 1992.
c
c
c  LIST OF INPUT ARGUEMENT VARIABLES
c
c     a(.) = initial parameter set
c     bl(.) = lower bound on parameters
c     bu(.) = upper bound on parameters
c     nopt = number of parameters to be optimized
c
c
c  LIST OF SCE ALGORITHMIC CONTROL PARAMETERS:
c
c     ngs = number of complexes in the initial population
c     npg = number of points in each complex
c     npt = total number of points in initial population (npt=ngs*npg)
c     nps = number of points in a sub-complex
c     nspl = number of evolution steps allowed for each complex before
c         complex shuffling
c     iseed = initial random seed
c
c  CONVERGENCE CHECK PARAMETERS
c
c     maxn = max no. of trials allowed before optimization is terminated
c     kstop = number of shuffling loops in which the criterion value must
c         chang by the given percentage before optimization is terminated
c     pcento = percentage by which the criterion value must change in
c         given number of shuffling loops
c     ipcnvg = flag indicating whether parameter convergence is reached
c         (i.e., check if gnrng is less than 0.001)
c         = 0, parameter convergence not satisfied
c         = 1, parameter convergence satisfied
c
c
c  LIST OF LOCAL VARIABLES
c     x(.,.) = coordinates of points in the population
c     xf(.) = function values of x(.,.)
c     xx(.) = coordinates of a single point in x
c     cx(.,.) = coordinates of points in a complex
c     cfq(.) = function values of cx(.,.)
c     s(.,.) = coordinates of points in the current simplex
c     sf(.) = function values of s(.,.)
c     bestx(.) = best point at current shuffling loop
c     bestf = function value of bestx(.)
c     worstx(.) = worst point at current shuffling loop
c     worstf = function value of worstx(.)
c     xnstd(.) = standard deviation of parameters in the population
c     gnrng = normalized geometric mean of parameter ranges
c     lcs(.) = indices locating position of s(.,.) in x(.,.)
c     bound(.) = bound on ith variable being optimized
c     ngs1 = number of complexes in current population
c     ngs2 = number of complexes in last population
c     iseed1 = current random seed
c     criter(.) = vector containing the best criterion values of the last
c         10 shuffling loops
c
c
c     AVG
!!    noptz        |none          |number of parameters to optimise
!!    xxo(:)       |none          |new values of the parameters 
!!    iiname(:)    |none          |code refering to which parameter to change, and how
!!    iobj         |none          |number of objective functions
!!    iniobj(:)    |none          |values of the objective functions of the initial run
!!    obj(:)       |none          |values of the objective functions
!!    icalw        |none          |weight given for the objectives
!!    wgoc         |none          |calculated GOC
!!    icalpar(:,:) |none          |objective functions codes of CALMET.DAT
!!    icalml       |none          |number of simulation run
!!    iinr(:)      !              |number of HRUs to change for parameter (:)
!!    inrhru(:,:)  |none          |list of HRU numbers to change  
!!    obj(:)       |none          |values of the objective functions
!!    ffz(:)       |none          |transformed objectif function

c     AVG

c  ARRAYS FROM THE INPUT DATA
      use parm1
      implicit real*8 (a-h,o-z)
      include 'mpif.h'
      real*8 a(nopt)
      integer inrhru(nopt,2000), npt1,nopt,iobj, imet(nopt), nobs(iobj)
      integer icalpar(4,iobj),iiname(nopt), iinr(nopt),lcs(50)
	integer isens, isenspar(4,isens),igoc, npt,icd,iprob,istat
c
c  LOCAL ARRAYS
      real*8 x(npt,nopt), xx(nopt),bestx(nopt),worstx(nopt),xf(npt)
     *,snew(nopt), bbound(2,nopt), xxo(nopt), ss(nopt), xxf, fv
      real*8 s(nps,100),sf(nps),cx(npg,100),cfq(npg), calw(iobj)
      real*8 xnstd(100),bound(nopt),criter(20),unit(100), xxfz
      real*8 obj(iobj), iniobjf(iobj),omin(iobj), varobj(igoc)
	real*8 criteromin(20,igoc), bbound2(2,nopt),varval(iobj)
      real*8 ffz(iobj), bu(nopt),bl(nopt),fa,fnew, sensw(isens)
	real*8 xfz(npt,igoc), sfz(nps,igoc), cfzq(npg,igoc), vartot
      real*8 obj_send(1:nopt+2), obj_recv(1:nopt+2)
      real*8 sumf,swq(nopt),ae(nopt),ce(nopt),Pa(npt),sum_Pa
	integer ic(npt),is(nps),ix(npt),flag,beg(3)
        integer rep1(nprocs1),rep2(nprocs1),rep3(nprocs1)
	character*10 parname(nopt)
        integer status(mpi_status_size)
	criteromin = 0.
        allocate(iitel3(1000))       !liqiang
        allocate(obj1(1, 1000))
        allocate(iitelnum3(nprocs1))
        allocate(arr_begin3(nprocs1))
        allocate(arr_amount3(nprocs1))
        allocate(icalml1(10000))
        allocate(xx1(nopt, 10000))
        allocate(iitelnum4(nprocs1))
        allocate(arr_begin4(nprocs1))
        allocate(arr_amount4(nprocs1))
c
cc

      write (*,*) ' ENTER THE SCEUA SUBROUTINE --- '     


c  ALGORITHM GENERATE A NEW POINT(S) FROM A SUB-COMPLEX
c
c  SUB-COMPLEX VARIABLES
c


c  INITIALIZE VARIABLES
      alpha = 0.2
      iitel = 0
      nloop = 0
      loop = 0
      igs = 0
      nopt1 = 8
      if (nopt.lt.8) nopt1 = nopt
      nopt2 = 12
      if (nopt.lt.12) nopt2 = nopt
        do ik=1,nopt
        bl(ik)=bbound(1,ik)
        bu(ik)=bbound(2,ik)
        end do


c
c  INITIALIZE RANDOM SEED TO A NEGATIVE INTEGER
      iseed1 = -abs(iseed)
c
c  COMPUTE THE TOTAL NUMBER OF POINTS IN INITIAL POPUALTION

      npt = ngs * npg
      ngs1 = ngs
      npt1 = npt
c
      write(18011,400)
      write (*,*) ' ***  Evolution Loop Number ',nloop
c
c  COMPUTE THE BOUND FOR PARAMETERS BEING OPTIMIZED
      do j = 1, nopt
        bound(j) = bbound(2,j) - bbound(1,j)
        unit(j) = 1.0
      end do
c
c  COMPUTE THE FUNCTION VALUE OF THE INITIAL POINT
      icalml = 0
      call objfunctn(obj,iobj, icalpar, icalml,icd)

      if (icalml .ge. maxn) go to 9000
       do mm=1,igoc
      omin(mm)=obj(mm)
      iniobjf(mm)= obj(mm)
	
       end do
	do ii=1,iobj
	if (icalpar(2,ii).eq.1) then
	vv= 1.-omin(ii)/nobs(ii)/varval(ii)	
	write(18011,*)'Initial Nash-Sutcliff efficiency of OF ',ii,
     *	'=',vv
	end if
	end do
       write(*,*) 'CPU:',myid1,'omin1=',omin
c
c  PRINT THE INITIAL POINT AND ITS CRITERION VALUE


c
c  GENERATE AN INITIAL SET OF npt1 POINTS IN THE PARAMETER SPACE

c
c  ELSE, GENERATE A POINT RANDOMLY AND SET IT EQUAL TO x(1,.)

c
c  GENERATE npt1-1 RANDOM POINTS DISTRIBUTED UNIFORMLY IN THE PARAMETER
c  SPACE, AND COMPUTE THE CORRESPONDING FUNCTION VALUES
	 do i = 1, npt1
	icalml = icalml + 1
        call getpnt(nopt,1,iseed1,xx,bl,bu,unit,bl)
        do j = 1, nopt
          x(i,j) = xx(j)
        end do
        xxo=xx
	call functn(xxo,nopt, iiname, inrhru, iinr, icalml,iobj,
     *	 icalpar, isens, isenspar, sensw,obj, imet,icd)
       do mm=1,igoc
        xfz(i,mm)= obj(mm)
        omin(mm)=min(omin(mm), obj(mm))
       end do

        if (icalml .ge. maxn) then
          npt1 = i
          go to 45
        end if
      end do

	vartot=0.
	do mm=1,igoc
	varobj(mm)=omin(mm)/nobs(mm)
	vartot=vartot+varobj(mm)
	end do
	fa=0.
	do mm=1,igoc
	  ffz(mm)=obj(mm)/(varobj(mm)*2)
	  fa=fa+ffz(mm)
	end do
	fa=fa*vartot
        i=0
        write(18019,6666) i, (ffz(mm), mm=1,igoc), fa
6666    format(i5, 41e12.5)	
        do i=1, npt1
        xf(i)=0. 
        ix(i)=i
        do mm=1,igoc
        obj(mm)=xfz(i,mm)
	  ffz(mm)=obj(mm)/(varobj(mm)*2)
	  xf(i)= xf(i)+ffz(mm)
        end do
	  xf(i)=xf(i)*vartot

        write(18019,6666) i, (ffz(mm), mm=1,igoc), xf(i)
        end do

       write(*,*) 'CPU:',myid1,'omin2=',omin

c	
c  ARRANGE THE POINTS IN ORDER OF INCREASING FUNCTION VALUE
   45 call sort3(npt1,nopt,x,xf,xfz,ix,igoc)
c
c  RECORD THE BEST AND WORST POINTS
      do j = 1, nopt
        bestx(j) = x(1,j)
        worstx(j) = x(npt1,j)
      end do
      bestf = xf(1)
      worstf = xf(npt1)
c
c  COMPUTE THE PARAMETER RANGE FOR THE INITIAL POPULATION
      call parstt2(npt1,nopt,x,xnstd,bound,gnrng,ipcnvg,bbound,bbound2)
c

  201 continue
      rewind(18020)
	write(18020,1812) ix(1), (bestx(j),j=1,nopt)
      write(18011,650) nloop
	write(18011,*)'best result corresponds to simulation' , ix(1)
      write(18011,610) 
	write(18011,630) nloop,icalml,ngs1,gnrng
	do ii=1,iobj
	if (icalpar(2,ii).eq.1) then
	vv= 1.-omin(ii)/nobs(ii)/varval(ii)	
	write(18011,*)'Lowest Nash-Sutcliff efficiency of OF',ii,'=',vv
	end if
	end do

	call parasolunc(iobj,igoc,nopt,icalml,istat, iprob,bbound,
     *	parname, ntot,omin,nobs,nintval, iiname, inrhru, iinr,
     *isens,icalpar, isenspar, sensw, imet)
  301 continue

c
      if (icalml .ge. maxn) go to 9000
      if (ipcnvg .eq. 1) go to 9200
c
c  BEGIN THE MAIN LOOP ----------------
 1000 continue
      nloop = nloop + 1
c
      write (*,*) ' ***  Evolution Loop Number ',nloop

	vartot=0.
	do mm=1,igoc
	varobj(mm)=omin(mm)/nobs(mm)
	vartot=vartot+varobj(mm)
	end do

667	format(100e12.5)
        do i=1, npt1

        xf(i)=0. 
        do mm=1,igoc
	  ffz(mm)=xfz(i,mm)/(varobj(mm)*2)
	  xf(i)= xf(i)+ffz(mm)
        end do
	  xf(i)= xf(i)*vartot
        end do

	call sort3(npt1,nopt,x,xf,xfz,ix,igoc)
	do i = npt1-ngs1, npt1
	icalml = icalml + 1
        call getpnt(nopt,1,iseed1,xx,bl,bu,unit,bl)
        do j = 1, nopt
          x(i,j) = xx(j)
        end do
        xxo=xx

	call functn(xxo,nopt, iiname, inrhru, iinr, icalml,iobj,
     *	 icalpar, isens, isenspar, sensw,obj, imet,icd)
	     xf(i)=0. 
       do mm=1,igoc
        xfz(i,mm)= obj(mm)
        omin(mm)=min(omin(mm), obj(mm))
        ffz(mm)=xfz(i,mm)/(varobj(mm)*2)
	  xf(i)= xf(i)+ffz(mm)
        end do
	  xf(i)= xf(i)*vartot
	write(18019,6666) icalml, (ffz(mm), mm=1,igoc), xf(i)
  	end do	

	call sort3(npt1,nopt,x,xf,xfz,ix,igoc)
        rep1 = 0
        rep2 = 0
        rep3 = 0

!        call mpi_type_contiguous(2,mpi_double_precision,tworeal,ierr)
!        call mpi_type_commit(tworeal, ierr)

c
c  BEGIN LOOP ON COMPLEXES

      if(myid1 .ne. 0) then
        do i = 1, npt1
           if(myid1 == i) then
             do j = 1, nopt
               ss(j) = x(i,j)
             end do
           end if
         end do
       end if
      flag = 0
      i = 0
      rep = 0
      do while(flag .ne. 1)
        if(myid1 == 0) then
           write(*,*) 'CPU0 XF RECEIVING'
           call mpi_recv(obj_recv,nopt+2,mpi_double_precision,          &
     &     mpi_any_source,mpi_any_tag,mpi_comm_world,status,ierr)
           write(*,*) 'CPU0 XF RECEIVED FROM CPU',status(mpi_source)
           icalml = icalml + 1
           write(*,*) 'icalml=',icalml
           if(obj_recv(2) .lt. worstf) then
               write(*,*) 'NEW POINT FOUND!'
               write(*,*) 'BESTF=',bestf
               write(*,*) 'WORSTF=',worstf
!               if(xf(npt1).eq.obj_recv(2)) then
!                   rep = rep + 1 
!                   if(rep .GT. 20) then
!                      call getpnt(nopt,1,iseed1,snew,bl,bu,unit,bl)
!                      write(*,*) 'NEW POINT GENERATED'
!                      call mpi_send(snew,nopt,mpi_double_precision,     &
!     &                status(mpi_source),myid,mpi_comm_world,ierr)
!                      cycle
!                   end if
!               end if
               rep1(status(mpi_source)) = 0
               rep2(status(mpi_source)) = 0
               rep3(status(mpi_source)) = 0
               do j = 1, nopt
                  x(npt1,j) = obj_recv(j+2)
               end do
               xf(npt1) = obj_recv(2)
               xfz(npt1, igoc) = obj_recv(1)

               call sort3(npt1,nopt,x,xf,xfz,ix,igoc)

               do j = 1, nopt
                  bestx(j) = x(1,j)
                  worstx(j) = x(npt1,j)
               end do
               bestf = xf(1)
               worstf = xf(npt1)

               if (icalml .ge. maxn) go to 9000
               icrit=1
               criter(20) = bestf
               if (nloop .lt. (kstop+1)) go to 132
               denomi = dabs(criter(20-kstop) + criter(20)) / 2.
               timeou = dabs(criter(20-kstop) - criter(20)) / denomi
               if (timeou .ge. pcento) icrit=icrit*0
               do k=1,igoc
                  criteromin(20,k) = omin(k)
                  denomi = dabs(criteromin(20-kstop,k) +                &
     &            criteromin(20,k)) / 2.
                  timeou = dabs(criteromin(20-kstop,k) -                &
     &            criteromin(20,k)) / denomi
                  if (timeou .ge. pcento) icrit=icrit*0
               end do
               if (icrit.eq.1) go to 9100
  132          continue
               do l = 1, 19
                  criter(l) = criter(l+1)
               end do
               do k=1,igoc
                  do l = 1, 19
                    criteromin(l,k) = criteromin(l+1,k)
                  end do
               end do
cIF POPULATION IS CONVERGED INTO A SUFFICIENTLY SMALL SPACE
               call parstt2(npt1,nopt,x,xnstd,bound,gnrng,ipcnvg,       &
     &         bbound,bbound2)
               if (ipcnvg .eq. 1) then
                   write(*,*) 'loop will jump out!'
                   flag = 1
                   go to 9200
               end if
               !GA Start      
               !compute the possibility
               sumf =  0              
               do j = 1, npt1 - 1
                  sumf = sumf + xf(j)
               end  do
               write(*,*) 'sumf=',sumf
               do j = 1, npt1 - 1
                  Pa(j) = xf(npt1 - j)/sumf
               end do
               !select a random point
               i = 1
               sum_Pa = Pa(i)
               call random_seed()
               call random_number(rand)
               r = (rand*10)/10.0
               do while(r .GT. sum_Pa)
                  i = i + 1
                  sum_Pa = sum_Pa + Pa(i)
!                  write(*,*) 'sum=',sum_Pa
               end do
               !select a random coordinate
               call random_seed()
               call random_number(rand)
               j = floor(rand*21+1)
               x(npt1, j) = x(i, j)
               do k = 1, nopt
                  snew(k) = x(npt1, k)
               end do
               write(*,*) 'NEW POINT0 WILL BE SENT'
               call mpi_send(snew,nopt,mpi_double_precision,            &
     &         status(mpi_source),myid,mpi_comm_world,ierr)
               write(*,*) 'NEW POINT0 HAS BEEN SENT'
           else if(rep1(status(mpi_source)) .LE. nopt/2) then
               write(*,*) 'BETTER POINT NEEDED!'
               !compute the possibility
               sumf =  0
               do j = 1, npt1 - 1 
                  sumf = sumf + xf(j)
               end  do
               do j = 1, npt1 - 1
                  Pa(j) = xf(npt1 - j)/sumf
               end do
               !select a random point
               i = 1
               sum_Pa = Pa(i)
               call random_seed()
               call random_number(rand)
               r = (rand*10)/10.0
               do while(r .GT. sum_Pa)
                  i = i + 1
                  sum_Pa = sum_Pa + Pa(i)
               end do
               !select a random coordinate
               call random_seed()
               call random_number(rand)
               j = floor(rand*21+1)
               obj_recv(j+2) =  x(i, j)
               do k = 1, nopt
                  snew(k) = obj_recv(k+2)
               end do
               rep1(status(mpi_source)) = rep1(status(mpi_source)) + 1
               write(*,*) 'NEW POINT1 WILL BE SENT'
               call mpi_send(snew,nopt,mpi_double_precision,            &
     &         status(mpi_source),myid,mpi_comm_world,ierr)
               write(*,*) 'NEW POINT1 HAS BEEN SENT'

           else if(rep2(status(mpi_source)) .LE. nopt/2) then
               !compute the possibility
               sumf =  0
               do j = 1, npt1 - 1
                  sumf = sumf + xf(j)
               end  do
               do j = 1, npt1 - 1
                  Pa(j) = xf(npt1 - j)/sumf
               end do
               !select a random point
               i = 1
               sum_Pa = Pa(i)
               call random_seed()
               call random_number(rand)
               r = (rand*10)/10.0
               do while(r .GT. sum_Pa)
                  i = i + 1
                  sum_Pa = sum_Pa + Pa(i)
               end do
               !select some continuous coordinates
               call random_seed()
               beg(1) = 0
               beg(2) = 0
               do while (beg(1) .EQ. beg(2))
                  call random_number(rand)
                  beg(1) = floor(rand*21+1)
                  call random_number(rand)
                  beg(2) = floor(rand*21+1)
               end do
               if(beg(1) .GT. beg(2)) then
                  beg(3) = beg(1)
                  beg(1) = beg(2)
                  beg(2) = beg(3)
               end if
               do k = beg(1), beg(2)
                  obj_recv(k+2) =  x(i, k)
               end do
               do k = 1, nopt
                  snew(k) = obj_recv(k+2)
               end do
               rep2(status(mpi_source)) = rep2(status(mpi_source)) + 1
               write(*,*) 'NEW POINT2 WILL BE SENT'
               call mpi_send(snew,nopt,mpi_double_precision,            &
     &         status(mpi_source),myid,mpi_comm_world,ierr)   
               write(*,*) 'NEW POINT2 HAS BEEN SENT'

           else if(rep3(status(mpi_source)) .LE. nopt/2) then
               !select a random coordinate
               call random_seed()
               call random_number(rand)
               j = floor(rand*21+1)
               do while (obj_recv(j+2) .EQ. ((bu(j)-bl(j))/2))
                  call random_number(rand)
                  j = floor(rand*21+1)
               end do
               if(obj_recv(j+2) .GT. ((bu(j)-bl(j))/2)) then
                  obj_recv(j+2) = (bu(j)-bl(j))/2 - (obj_recv(j+2) -    &
     &                            (bu(j)-bl(j))/2)
               else
                  obj_recv(j+2) = (bu(j)-bl(j))/2 + ((bu(j)-bl(j))/2 -  &
     &                            obj_recv(j+2))
               end if
               do k = 1, nopt
                  snew(k) = obj_recv(k+2)
               end do
               rep3(status(mpi_source)) = rep2(status(mpi_source)) + 1
               write(*,*) 'NEW POINT3 WILL BE SENT'
               call mpi_send(snew,nopt,mpi_double_precision,            &
     &         status(mpi_source),myid,mpi_comm_world,ierr)
               write(*,*) 'NEW POINT3 HAS BEEN SENT'

           else
               call getpnt(nopt,1,iseed1,snew,bl,bu,unit,bl)
               write(*,*) 'NEW POINT4 WILL BE SENT'
               call mpi_send(snew,nopt,mpi_double_precision,            &
     &         status(mpi_source),myid,mpi_comm_world,ierr)
               write(*,*) 'NEW POINT4 HAS BEEN SENT'
           end if 
           !GA End  
           
        else
           write(*,*) 'CPU',myid1,'entered'
           call functn(ss,nopt, iiname, inrhru, iinr, icalml,iobj,      &
     &     icalpar, isens, isenspar, sensw,obj, imet,icd)
           xxf = 0
           do mm=1,igoc
           xxfz = obj(mm)
              omin(mm)=min(omin(mm), obj(mm))
              ffz(mm)=obj(mm)/(varobj(mm)*2)
              xxf = xxf+ffz(mm)       
           end do
           xxf =  xxf * vartot
           obj_send(1) = xxfz
           obj_send(2) = xxf
           do i = 3, nopt+2
              obj_send(i) = ss(i - 2)
           end do
           write(*,*) 'CPU:',myid1,'WILL SEND XF'
           call mpi_send(obj_send,nopt+2,mpi_double_precision,0,myid,   &
     &     mpi_comm_world,ierr) 
           write(*,*) 'CPU:',myid1,'SEND XF COMPLETED'
           call mpi_recv(ss,nopt,mpi_double_precision,0,mpi_any_tag,    &
     &     mpi_comm_world,status,ierr)

        end if
      end do

      do 3000 igs = 1, ngs1
c
c  ASSIGN POINTS INTO COMPLEXES
      do k1 = 1, npg
        k2 = (k1-1) * ngs1 + igs
        do j = 1, nopt
          cx(k1,j) = x(k2,j)
        end do
	  do j = 1, igoc
          cfzq(k1,j) = xfz(k2,j)
        end do
        cfq(k1) = xf(k2)
	  ic(k1)=ix(k2)
      end do
c
c  BEGIN INNER LOOP - RANDOM SELECTION OF SUB-COMPLEXES ---------------
      do 2000 loop = 1, nspl
c
c  CHOOSE A SUB-COMPLEX (nps points) ACCORDING TO A LINEAR
c  PROBABILITY DISTRIBUTION
      if (nps .eq. npg) then
        do k = 1, nps
          lcs(k) = k
        end do
        go to 85
      end if
c
      rand = ran1(iseed1)
      lcs(1) = 1 + dint(npg + 0.5 - dsqrt( (npg+.5)**2 -
     *         npg * (npg+1) * rand ))
      do k = 2, nps
   60   rand = ran1(iseed1)
        lpos = 1 + dint(npg + 0.5 - dsqrt((npg+.5)**2 -
     *         npg * (npg+1) * rand ))
        do k1 = 1, k-1
          if (lpos .eq. lcs(k1)) go to 60
        end do
        lcs(k) = lpos
      end do
c
c  ARRANGE THE SUB-COMPLEX IN ORDER OF INCEASING FUNCTION VALUE
      call sort1(nps,lcs)
c
c  CREATE THE SUB-COMPLEX ARRAYS
   85 do k = 1, nps
        do j = 1, nopt
          s(k,j) = cx(lcs(k),j)
        end do
	  do j = 1, igoc
          sfz(k,j) = cfzq(lcs(k),j)
        end do
        sf(k) = cfq(lcs(k))
	  is(k)=ic(lcs(k))
      end do
c
c  USE THE SUB-COMPLEX TO GENERATE NEW POINT(S)
      call  parasolcce(nopt,nps,s,sf,sfz,bl,bu,xnstd,icalml,maxn,iseed,
     *itel, iiname, inrhru, iinr,iobj,igoc, icalpar, isens, isenspar, 
     * sensw, imet, varobj,omin,npt,is,bbound2,icd)

c
c  IF THE SUB-COMPLEX IS ACCEPTED, REPLACE THE NEW SUB-COMPLEX
c  INTO THE COMPLEX
      do k = 1, nps
        do j = 1, nopt
          cx(lcs(k),j) = s(k,j)
        end do
	  do j = 1, igoc
          cfzq(lcs(k),j) = sfz(k,j)
        end do
        cfq(lcs(k)) = sf(k)
	  ic(lcs(k))=is(k)
      end do

c
c
c  SORT THE POINTS
 
      call sort3(npg,nopt,cx,cfq,cfzq,ic,igoc)
c
c  IF MAXIMUM NUMBER OF RUNS EXCEEDED, BREAK OUT OF THE LOOP
      if (icalml .ge. maxn) go to 2222
c
c  END OF INNER LOOP ------------
 2000 continue
 2222 continue
c
c  REPLACE THE NEW COMPLEX INTO ORIGINAL ARRAY x(.,.)
      do k1 = 1, npg
        k2 = (k1-1) * ngs1 + igs
        do j = 1, nopt
          x(k2,j) = cx(k1,j)
        end do
        do j = 1, igoc
          xfz(k2,j) = cfzq(k1,j)
        end do
        xf(k2) = cfq(k1)
		ix(k2)=ic(k1)
      end do

      if (icalml .ge. maxn) go to 3333
c
c  END LOOP ON COMPLEXES
 3000 continue
c
c  RE-SORT THE POINTS
 3333 call sort3(npt1,nopt,x,xf,xfz,ix,igoc)
c
c  RECORD THE BEST AND WORST POINTS
      do j = 1, nopt
        bestx(j) = x(1,j)
        worstx(j) = x(npt1,j)
      end do
      bestf = xf(1)
      worstf = xf(npt1)

c
c  TEST THE POPULATION FOR PARAMETER CONVERGENCE
      call parstt2(npt1,nopt,x,xnstd,bound,gnrng,ipcnvg,bbound,bbound2)
c
c  PRINT THE RESULTS FOR CURRENT POPULATION

1812  format(i5,100e12.5)
	write(18011,*)'best result corresponds to simulation' , ix(1)
      write(18011,610) 
	write(18011,630) nloop,icalml,ngs1,gnrng
	do ii=1,iobj
	if (icalpar(2,ii).eq.1) then
	vv= 1.-omin(ii)/nobs(ii)/varval(ii)	
	write(18011,*)'Lowest Nash-Sutcliff efficiency of OF',ii,'=',vv
	end if
	end do

	call parasolunc(iobj,igoc,nopt,icalml,istat, iprob,bbound,
     *	parname, ntot,omin,nobs,nintval, iiname, inrhru, iinr,
     *isens,icalpar, isenspar, sensw, imet)


c	write the bestpar file
      rewind(18020)
	write(18020,1812) ix(1), (bestx(j),j=1,nopt)
c
c  TEST IF MAXIMUM NUMBER OF FUNCTION EVALUATIONS EXCEEDED
      if (icalml .ge. maxn) go to 9000
c
c  COMPUTE THE COUNT ON SUCCESSIVE LOOPS W/O FUNCTION IMPROVEMENT
!      icrit=1
	
!	criter(20) = bestf
!      if (nloop .lt. (kstop+1)) go to 132
!      denomi = dabs(criter(20-kstop) + criter(20)) / 2.
!      timeou = dabs(criter(20-kstop) - criter(20)) / denomi
!      if (timeou .ge. pcento) icrit=icrit*0
!	do k=1,igoc
!      criteromin(20,k) = omin(k)
!      denomi = dabs(criteromin(20-kstop,k) + criteromin(20,k)) / 2.
!      timeou = dabs(criteromin(20-kstop,k) - criteromin(20,k)) / denomi
!      if (timeou .ge. pcento) icrit=icrit*0
!	end do
!	 if (icrit.eq.1) go to 9100
!  132 continue
!        do l = 1, 19
!        criter(l) = criter(l+1)
!      end do
!	do k=1,igoc
!      do l = 1, 19
!        criteromin(l,k) = criteromin(l+1,k)
!      end do
!	end do
c
c  IF POPULATION IS CONVERGED INTO A SUFFICIENTLY SMALL SPACE
      if (ipcnvg .eq. 1) go to 9200
c
c  NONE OF THE STOPPING CRITERIA IS SATISFIED, CONTINUE SEARCH
c

c
c  END OF MAIN LOOP -----------
      go to 1000
c
c  SEARCH TERMINATED
 9000 continue
      write(18011,800) maxn,loop,igs,nloop
      go to 9999
 9100 continue
      write(18011,810) pcento*100.,kstop
      go to 9999
 9200 write(18011,820) gnrng*100.
 9999 continue
c
c  PRINT THE FINAL PARAMETER ESTIMATE AND ITS FUNCTION VALUE

      rewind(18020)
	write(18020,1812) ix(1), (bestx(j),j=1,nopt)
  801 continue
99988 continue
c
c  END OF SUBROUTINE SCEUA
      return
  400 format(//,2x,50(1h=),/,2x,'ENTER THE SHUFFLED COMPLEX EVOLUTION',
     &       ' GLOBAL SEARCH',/,2x,50(1h=))
  500 format(//,'*** PRINT THE INITIAL CRITERION ',
     &       'VALUE ***')
  510 format(/,' CRITERION',12(6x,a4),/1x,60(1h-))
  520 format(g10.3,12f10.3)
  530 format(10x,12(6x,a4))
  540 format(10x,12f10.3)
  600 format(//,1x,'*** PRINT THE RESULTS OF THE SCE SEARCH ***')
  610 format(/,1x,'LOOP',1x,'TRIALS',1x,'COMPLXS',2x,'PAR RNG')
  640 format(49x,8(f10.3))
  630 format(i5,1x,i5,3x,i5,g10.3)
  650 format(/,1x,'RESULTS FOR LOOP ',i3,/,1x,22(1h-))
  660 format(15x,g10.3,20x,8(f10.3))
  800 format(//,1x,'*** OPTIMIZATION SEARCH TERMINATED BECAUSE THE',
     &       ' LIMIT ON THE MAXIMUM',/,5x,'NUMBER OF TRIALS ',i5,
     &       ' EXCEEDED.  SEARCH WAS STOPPED AT',/,5x,'SUB-COMPLEX ',
     &       i3,' OF COMPLEX ',i3,' IN SHUFFLING LOOP ',i3,' ***')
  810 format(//,1x,'*** OPTIMIZATION TERMINATED BECAUSE THE CRITERION',
     &       ' VALUE HAS NOT CHANGED ',/,5x,f5.2,' PERCENT IN',i3,
     &       ' SHUFFLING LOOPS ***')
  820 format(//,1x,'*** OPTIMIZATION TERMINATED BECAUSE THE POPULATION',
     &       ' HAS CONVERGED INTO ',/,4x,f5.2,' PERCENT OF THE',
     &       ' FEASIBLE SPACE ***')
  830 format(//,'*** PRINT THE FINAL PARAMETER ESTIMATE AND ITS',
     &       ' CRITERION VALUE ***')
      end
