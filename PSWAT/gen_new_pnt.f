!      program main
      subroutine gen_new_pnt(x,xf,npt1,nopt,bu,bl,iseed,unit)

      integer beg(3)
      real*8 xx(nopt),xxx(nopt),x(npt1,nopt),xf(npt1)
      real*8 bu(nopt),bl(nopt)

      xx = 0.0
      
      call random_seed()
      call random_number(rand)

      if(rand .GT. 0.5) then
!     crossover
!         call random_seed()
         beg(1) = 0
         beg(2) = 0
         do while (beg(1) .EQ. beg(2))
            call random_number(rand)
            beg(1) = floor(rand*nopt+1)
            call random_number(rand)
            beg(2) = floor(rand*nopt+1)
            write(*,*) 'Z',beg(1),beg(2)
         end do
         if(beg(1) .GT. beg(2)) then
            beg(3) = beg(1)
            beg(1) = beg(2)
            beg(2) = beg(3)
         end if
         do i = beg(1), beg(2)
            xx(i) = x(1,i)
         end do
         do i = 1, npt1/2 + 1
            do j = beg(1), beg(2)
               x(i,j) = x(i+1,j)
            end do
         end do
         do i = beg(1), beg(2)
            x(npt1/2+1,i) = xx(i)
         end do
      else
!     mutation   
!         call random_seed() 
         do i = 1, npt1/2 + 1
            call random_number(rand)
            j = floor(rand*nopt+1)
            do while (x(i,j) .EQ. ((bu(j)-bl(j))/2))
               call random_number(rand)
               j = floor(rand*nopt+1)
            end do
!            write(*,*) 'xij=',x(i,j),bu(j),bl(j) 
            if(x(i,j) .GT. ((bu(j)-bl(j))/2)) then
               x(i,j) = (bu(j)-bl(j))/2 - (x(i,j) -  (bu(j)-bl(j))/2)  
            else
               x(i,j) = (bu(j)-bl(j))/2 + ((bu(j)-bl(j))/2 - x(i,j))   
            end if 
!            write(*,*) 'xij=',x(i,j),bu(j),bl(j) 
         end do
      end if    
!     newpoint
      do i = npt1/2+1, npt1 
         call getpnt(nopt,1,iseed1,xxx,bl,bu,unit,bl)
         do j = 1, nopt
            x(i,j) = xxx(j)
         end do
      end do
      end
