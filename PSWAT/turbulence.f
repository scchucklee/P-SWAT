      subroutine turbulence(nopt)

      use parm1

!      write(*,*) 'brgggg=',brg
      call random_seed()
      do i = 1, crg
       do j = 1, nopt
          call random_number(rand)
          if(rand .GT. 0.5) then
              drg(i,j) = brg(j) * (1.0+0.1)
          else
              drg(i,j) = brg(j) * (1.0-0.1)
!          write(*,*) 'drg=',drg
          end if
       end do
      end do
!      write(*,*) 'drg=',drg
       end subroutine 
