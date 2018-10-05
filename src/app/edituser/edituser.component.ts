import { Component, OnInit, ViewChild } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute } from '@angular/router'
import swal from 'sweetalert2'
import { CookieService } from 'ngx-cookie-service';
import { UrlService } from '../url.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common'


@Component({
  selector: 'app-edituser',
  templateUrl: './edituser.component.html',
  styleUrls: ['./edituser.component.css']
})
export class EdituserComponent implements OnInit {
  urlbase: string
  user_name: any
  user: any[]
  get: any

  constructor(private http: HttpClient, private activatedRoute: ActivatedRoute, private cookie: CookieService, public service: UrlService, private router: Router,
    private location: Location, ) { this.urlbase = service.get_url(), this.service.nav = "user" }

  ngOnInit() {
    this.activatedRoute.params.subscribe(params => {
      if (!params["key"]) {
      } else {
        this.user_name = params["key"]
        this.select()
      }
    })
  }

  eye(data) {
    swal('รหัสผ่าน', 'รหัสผ่านคือ : ' + data, 'info')
  }

  select() {
    this.http.get<any[]>(this.urlbase + "myconn/user/select_user.php?user_name=" + this.user_name).subscribe(data => {
      this.user = data;
    })
  }

  edit() {
    if (this.user[0].password == "") {
      swal('รหัสผ่าน', 'กรุณากรอกรหัสผ่าน', 'warning')
    } else {
      let creds = JSON.stringify({ user_name: this.user[0].user_name, password: this.user[0].password });
      this.http.post(this.urlbase + "myconn/user/user_edit.php", creds, { responseType: 'text' })
        .subscribe(data => {
          this.get = data
          if (this.get == 1) {
            swal('เรียบร้อย', 'แก้ไขรหัสผ่านเรียบร้อยแล้ว', 'success')
            this.router.navigate(['user'])
          } else {
            swal('เกิดปัญหา', 'ไม่สามารถแก้ไขข้อมูลได้', 'error')
          }
        })
    }
  }


}
