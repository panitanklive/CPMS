import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { Location } from '@angular/common';
import { ActivatedRoute } from '@angular/router'
import { CookieService } from 'ngx-cookie-service';
import swal from 'sweetalert2'
import { UrlService } from '../url.service';
@Component({
  selector: 'app-map',
  templateUrl: './map.component.html',
  styleUrls: ['./map.component.css']
})
export class MapComponent implements OnInit {
  urlbase: string
  term = ""
  trsg: any[]
  get: any
  constructor(private http: HttpClient,
    private router: Router,
    private location: Location,
    public service: UrlService,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService) {
    this.urlbase = service.get_url()
    this.service.nav = "map"
  }

  ngOnInit() {
    this.feed_map();
  }

  feed_map() {
    this.http.get<any[]>(this.urlbase + 'myconn/map/feed_map.php').subscribe(data => {
      this.trsg = data;
    })
  }

  del(trsg_id) {
    swal({
      title: 'ต้องการลบสถานที่นี้<br>ออกจากระบบหรือไม่',
      text: "คลิกตกลงเพื่อยืนยันการลบ",
      type: 'question',
      showCancelButton: true,
      confirmButtonText: 'ok'
    }).then((result) => {
      if (result.value) {
        this.http.get<any[]>(this.urlbase + "myconn/map/del_trsg.php?trsg_id=" + trsg_id).subscribe(data => {
          this.get = data
          if(this.get == 1){
            swal('เรียบร้อย', 'ลบสถานที่เรียบร้อยแล้ว', 'success')
            this.feed_map();
          }else{
            swal('เกิดปัญหา', 'ไม่สามารถลบสถานที่ได้', 'success')
          }
        })
      } else {
        result.dismiss === swal.DismissReason.cancel
      }
    })
  }

}
