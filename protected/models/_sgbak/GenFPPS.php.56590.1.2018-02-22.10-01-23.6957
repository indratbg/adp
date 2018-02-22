<?php

Class GenFPPS extends CFormModel
{
	public $stk_cd;
	public $batch_opt;
	public $batch;
	public $format;
	public $type;
	
	public $begin_subrek;
	public $end_subrek;
	
	public function getFppsSql()
	{
		$sql = "SELECT ROW_NUMBER() OVER (ORDER BY SUBSTR(s.subrek001,6,4)) AS no, c.NAMA_PRSH AS nama_peap,
				decode(m.client_type_1,'C',nvl(y.id_desc,'NPWP'),y.id_desc) AS jenis_id,									
				TRIM(nvl(f.client_ic_num, f.npwp_no)) AS no_id, SUBSTR(m.client_name,1,40) AS nama_1, SUBSTR(m.client_name,41,10) AS nama_2,									
				SUBSTR(
					TRIM(
						DECODE(
							'$this->format',1,
							DECODE(m.client_type_1,'I',i.id_addr||' '||trim(i.id_rtrw)||' Kel. '||trim(i.id_klurahn),m.def_addr_1),
							DECODE(m.client_type_1,'I',i.id_addr||' '||trim(i.id_rtrw),m.def_addr_1)
						)
					)
				,1,40) AS alamat,
													
				SUBSTR(
					TRIM(
						DECODE(
							'$this->format',1,
							DECODE(m.client_type_1,'I',i.id_kcamatn,m.def_addr_2),
							DECODE(m.client_type_1,'I',trim(i.id_klurahn)||' - '||i.id_kcamatn,m.def_addr_2)
						)
					)
				,1,40) AS kecamatan,		
											
				SUBSTR(TRIM(DECODE(m.client_type_1,'I',i.id_kota, m.def_addr_3)),1,20) AS kota,									
				
				DECODE(
					m.client_type_1,'I',
					TO_CHAR(f.client_birth_dt,'dd/mm/yyyy'),
					DECODE('$this->format',1,TO_CHAR(f.client_birth_dt,'dd/mm/yyyy'),'01/01/1901')
				) AS tanggal_lahir,	
											
				DECODE(f.client_type_2,'F','A','L','I') AS warganegara,									
				b.biz_desc AS status,									
				DECODE(TO_CHAR(f.IC_EXPIRY_DT,'yyyy'),'9999','Seumur hidup',NULL,NULL,TO_CHAR(f.IC_EXPIRY_DT,'dd/mm/yyyy')) AS tanggal_id_expired, 									
				c.NAMA_PRSH AS partisipan,									
				s.subrek001 AS rekening_efek,									
				DECODE('$this->type','F',t.fixed_qty,'P',t.pool_qty,t.fixed_qty + t.pool_qty) AS jum_pesan,
				DECODE(SIGN(fixed_qty),1,'F','P') AS status_pesan								
				FROM T_IPO_CLIENT t, MST_CLIENT m, MST_CLIENT_INDI i, MST_CIF f, MST_COMPANY c, V_CLIENT_ID_TYPE y, V_CLIENT_BIZ_TYPE b, V_CLIENT_SUBREK14 s									
				WHERE t.stk_cd = '$this->stk_cd'									
				AND (t.batch = '$this->batch' OR '$this->batch_opt' = 1)									
				AND ('$this->type' IN ('F','%') AND t.fixed_qty <> 0 OR '$this->type' IN ('P','%') AND t.pool_qty <> 0 )	
				AND NVL(SUBSTR(s.subrek001,6,4),'ABCD') BETWEEN '$this->begin_subrek' AND '$this->end_subrek'								
				AND t.approved_stat = 'A'									
				AND t.client_cd = m.client_cd									
				AND m.cifs = f.cifs 									
				AND m.ic_type = y.id_type(+)							
				AND m.biz_type = b.biz_type(+)									
				AND m.cifs = i.cifs(+)									
				AND t.client_Cd = s.client_Cd(+)
				ORDER BY SUBSTR(s.subrek001,6,4), m.client_cd							
				";
		
		return $sql;
	}
	
	public function rules()
	{
		return array(
			array('stk_cd, batch_opt, format','required'),
			array('batch, type, begin_subrek, end_subrek','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'stk_cd' => 'Stock Code IPO',
			'batch_opt' => 'Batch'
		);
	}
}
