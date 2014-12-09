PROG =  PSWAT	

SRCS =	modparm.f addh.f albedo.f allocate_parms.f alph.f analyse.f anfert.f apex_day.f \
	apply.f ascrv.f atri.f aunif.f autocal.f autoirr.f automet.f aveval.f \
	bacteria.f batchin.f batchmain.f bayes.f buffer.f callsub.f \
	calresidu.f canopyint.f caps.f changepar.f chkcst.f clgen.f clicon.f \
	command.f command1.f conapply.f confert.f copyfile.f countobs.f \
	crackflow.f crackvol.f create_files.f crpmd.f curno.f dailycn.f \
	dayrch_reduce.f daystd_reduce.f decay.f dormant.f dstn1.f ee.f \
	eiusle.f enrsb.f erfc.f estimate_ksat.f etact.f etpot.f expo.f fert.f \
	filter.f finalbal.f functn.f gasdev.f gcycl.f gen_new_pnt.f getallo.f \
	getallo2.f getpnt.f getpnt2.f goc.f grass_wway.f graze.f grow.f \
	gw_no3.f gwmod.f gwnutr.f h2omgt_init.f harvestop.f harvgrainop.f \
	harvkillop.f header.f headout.f hhnoqual.f hhwatqual.f hmeas.f \
	hruaa.f hruallo.f hruday.f hrumon.f hrupond.f hruyr.f hydroinit.f \
	impnd_init.f impndaa.f impndday.f impndmon.f impndyr.f indexx.f \
	irr_rch.f irr_res.f irrigate.f irrsub.f jdt.f killop.f lakeq.f \
	lasthruarray.f latsed.f lwqdef.f main.f nfix.f \
	nitvol.f nlch.f nminrl.f nonzero.f noqual.f npup.f nrain.f nup.f \
	nuts.f oat.f objfunctn.f openwth.f operatn.f orgn.f parasol.f \
	parasolc.f parasoli.f parasolo.f \
	parasolu.f parstt2.f percmacro.f percmain.f \
	percmicro.f pestlch.f pestw.f pesty.f pgen.f pgenhr.f pkq.f plantop.f \
	pmeas.f pminrl.f pond.f pothole.f psed.f qman.f ran1.f ranked.f \
	rchaa.f rchday.f rchinit.f rchmon.f rchuse.f rchyr.f reachout.f \
	readatmodep.f readbsn.f readchan.f readchm.f readcnst.f readfcst.f \
	readfert.f readfig.f readfile.f readgw.f readhru.f readinpt.f \
	readlwq.f readmetf.f readmgt.f readmon.f readops.f readpest.f \
	readplant.f readpnd.f readres.f readrte.f readsol.f readsub.f \
	readswq.f readtill.f readurban.f readwgn.f readwus.f readwwq.f \
	readyr.f reccnst.f recday.f rechour.f recmon.f recyear.f regres.f \
	rerun.f rerunfile.f rerunps.f res.f resbact.f resinit.f resnut.f \
	response.f rewind_init.f rhgen.f route.f routres.f rsedaa.f rseday.f \
	rsedmon.f rsedyr.f rtbact.f rtday.f rteinit.f rthmusk.f rthourly.f \
	rthpest.f rthsed.f rtmusk.f rtout.f rtover.f rtpest.f rtsed.f \
	sample.f sample1.f sat_excess.f save.f saveconc.f scein.f scestat.f \
	schedule_ops.f sensin.f sensmain.f sim_initday.f sim_inityr.f \
	simulate.f simulate1.f slrgen.f smeas.f snom.f soil_chem.f soil_par.f \
	soil_phys.f soil_write.f solp.f solt.f sort1.f sort3.f sorteer.f \
	sorteer2.f sorteer3.f sorteer4.f sorteer5.f sorteer6.f std1.f std2.f \
	std3.f std_scnbcst.f stdaa.f stdaa1.f stdaa_asreduce.f \
	stdaa_atreduce.f stdaa_aureduce.f stdaa_reduce.f storeinitial.f \
	structure.f subaa.f subbasin.f subbasin1.f subday.f submon.f \
	substor.f subwq.f subyr.f sumv.f sunglasr.f sunglass.f sunglasu.f \
	surface.f surfst_h2o.f surfstor.f surq_daycn.f surq_greenampt.f \
	swbl.f sweep.f swu.f tair.f telobjre.f telobs.f telpar.f tgen.f \
	theta.f tillmix.f tmeas.f tran.f transfer.f tstr.f ttcoef.f turbulence.f urban.f \
	varinit.f varoute_reduce.f vbl.f virtual.f volq.f vrval.f washp.f \
	watbal.f watqual.f watqual2.f wattable.f watuse.f weatgn.f wetlan.f \
	wmeas.f wndgen.f writea.f writeaa.f writeaa1.f writed.f writed1.f \
	writem.f writeswatfile.f writeswatmain.f xisquare.f xiunc.f xmon.f \
	ysed.f zero0.f zero1.f zero2.f zeroini.f

OBJS =	modparm.o addh.o albedo.o allocate_parms.o alph.o analyse.o anfert.o apex_day.o \
	apply.o ascrv.o atri.o aunif.o autocal.o autoirr.o automet.o aveval.o \
	bacteria.o batchin.o batchmain.o bayes.o buffer.o callsub.o \
	calresidu.o canopyint.o caps.o changepar.o chkcst.o clgen.o clicon.o \
	command.o command1.o conapply.o confert.o copyfile.o countobs.o \
	crackflow.o crackvol.o create_files.o crpmd.o curno.o dailycn.o \
	dayrch_reduce.o daystd_reduce.o decay.o dormant.o dstn1.o ee.o \
	eiusle.o enrsb.o erfc.o estimate_ksat.o etact.o etpot.o expo.o fert.o \
	filter.o finalbal.o functn.o gasdev.o gcycl.o gen_new_pnt.o getallo.o \
	getallo2.o getpnt.o getpnt2.o goc.o grass_wway.o graze.o grow.o \
	gw_no3.o gwmod.o gwnutr.o h2omgt_init.o harvestop.o harvgrainop.o \
	harvkillop.o header.o headout.o hhnoqual.o hhwatqual.o hmeas.o \
	hruaa.o hruallo.o hruday.o hrumon.o hrupond.o hruyr.o hydroinit.o \
	impnd_init.o impndaa.o impndday.o impndmon.o impndyr.o indexx.o \
	irr_rch.o irr_res.o irrigate.o irrsub.o jdt.o killop.o lakeq.o \
	lasthruarray.o latsed.o lwqdef.o main.o nfix.o \
	nitvol.o nlch.o nminrl.o nonzero.o noqual.o npup.o nrain.o nup.o \
	nuts.o oat.o objfunctn.o openwth.o operatn.o orgn.o parasol.o \
	parasolc.o parasoli.o parasolo.o  \
	parasolu.o parstt2.o percmacro.o percmain.o \
	percmicro.o pestlch.o pestw.o pesty.o pgen.o pgenhr.o pkq.o plantop.o \
	pmeas.o pminrl.o pond.o pothole.o psed.o qman.o ran1.o ranked.o \
	rchaa.o rchday.o rchinit.o rchmon.o rchuse.o rchyr.o reachout.o \
	readatmodep.o readbsn.o readchan.o readchm.o readcnst.o readfcst.o \
	readfert.o readfig.o readfile.o readgw.o readhru.o readinpt.o \
	readlwq.o readmetf.o readmgt.o readmon.o readops.o readpest.o \
	readplant.o readpnd.o readres.o readrte.o readsol.o readsub.o \
	readswq.o readtill.o readurban.o readwgn.o readwus.o readwwq.o \
	readyr.o reccnst.o recday.o rechour.o recmon.o recyear.o regres.o \
	rerun.o rerunfile.o rerunps.o res.o resbact.o resinit.o resnut.o \
	response.o rewind_init.o rhgen.o route.o routres.o rsedaa.o rseday.o \
	rsedmon.o rsedyr.o rtbact.o rtday.o rteinit.o rthmusk.o rthourly.o \
	rthpest.o rthsed.o rtmusk.o rtout.o rtover.o rtpest.o rtsed.o \
	sample.o sample1.o sat_excess.o save.o saveconc.o scein.o scestat.o \
	schedule_ops.o sensin.o sensmain.o sim_initday.o sim_inityr.o \
	simulate.o simulate1.o slrgen.o smeas.o snom.o soil_chem.o soil_par.o \
	soil_phys.o soil_write.o solp.o solt.o sort1.o sort3.o sorteer.o \
	sorteer2.o sorteer3.o sorteer4.o sorteer5.o sorteer6.o std1.o std2.o \
	std3.o std_scnbcst.o stdaa.o stdaa1.o stdaa_asreduce.o \
	stdaa_atreduce.o stdaa_aureduce.o stdaa_reduce.o storeinitial.o \
	structure.o subaa.o subbasin.o subbasin1.o subday.o submon.o \
	substor.o subwq.o subyr.o sumv.o sunglasr.o sunglass.o sunglasu.o \
	surface.o surfst_h2o.o surfstor.o surq_daycn.o surq_greenampt.o \
	swbl.o sweep.o swu.o tair.o telobjre.o telobs.o telpar.o tgen.o \
	theta.o tillmix.o tmeas.o tran.o transfer.o tstr.o ttcoef.o turbulence.o urban.o \
	varinit.o varoute_reduce.o vbl.o virtual.o volq.o vrval.o washp.o \
	watbal.o watqual.o watqual2.o wattable.o watuse.o weatgn.o wetlan.o \
	wmeas.o wndgen.o writea.o writeaa.o writeaa1.o writed.o writed1.o \
	writem.o writeswatfile.o writeswatmain.o xisquare.o xiunc.o xmon.o \
	ysed.o zero0.o zero1.o zero2.o zeroini.o

LIBS =	

CC = icc
CFLAGS = 
FC = mpif77
FFLAGS = 
F90 = mpif90
F90FLAGS = 
LDFLAGS = 

all: $(PROG)

$(PROG): $(OBJS)
	$(FC) $(LDFLAGS) -o $@ $(OBJS) $(LIBS)

clean:
	rm -f $(PROG) $(OBJS) *.mod

.SUFFIXES: $(SUFFIXES) .f90

.f90.o:
	$(F90) $(F90FLAGS) -c $<

