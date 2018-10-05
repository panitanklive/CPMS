import { Component, OnInit, ViewChild } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from "@angular/router";
import swal from "sweetalert2";
import { CookieService } from "ngx-cookie-service";
import { UrlService } from "../url.service";
import { Router } from "@angular/router";
import { Location } from "@angular/common";

@Component({
  selector: 'app-report2',
  templateUrl: './report2.component.html',
  styleUrls: ['./report2.component.css']
})
export class Report2Component implements OnInit {
  urlbase: string;
  peet: any[];
  trip_start = "";
  trip_end = "";
  _carpool_id: any;
  trsg: any[];
  trsg_id: any;

  constructor(
    private http: HttpClient,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService,
    public service: UrlService,
    private router: Router,
    private location: Location
  ) {
    (this.urlbase = service.get_url()), (this.service.nav = "report");
  }

  ngOnInit() {
    this.feed_car();
   
  }


  feed_car() {
    this.http
      .get<any[]>(this.urlbase + "myconn/report/feed_car.php")
      .subscribe(data => {
        this.peet = data;
      });
  }

  alert() {
    swal("วันที่", "คุณเลือกวันที่ไม่ถูกต้อง", "warning");
  }
}
