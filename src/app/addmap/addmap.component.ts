import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";

@Component({
  selector: "app-addmap",
  templateUrl: "./addmap.component.html",
  styleUrls: ["./addmap.component.css"]
})
export class AddmapComponent implements OnInit {
  urlbase: string;
  trsg_city: any;
  trsg_id = "";
  trsg_name = "";
  trsg_map = "";
  btnName = "เพิ่ม";
  get: any;

  trsg_any = [
    { name: "กรุงเทพฯ" },
    { name: "นครนายก" },
    { name: "ปทุมธานี" },
    { name: "ปราจีนบุรี" },
    { name: "พระนครศรีอยุธยา" },
    { name: "สระแก้ว" },
    { name: "สระบุรี" },
    { name: "อ่างทอง" }
  ];

  constructor(
    private http: HttpClient,
    private router: Router,
    private location: Location,
    public service: UrlService,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService
  ) {
    this.urlbase = service.get_url();
    this.service.nav = "map";
  }

  ngOnInit() {}

  add() {
    if (this.trsg_id == "") {
      swal("รหัสสถานที่", "กรุณากรอกรหัสสถานที่", "warning");
    } else if (this.trsg_name == "") {
      swal("ชื่อสถานที่", "กรุณากรอกชื่อสถานที่เดินทาง", "warning");
    } else if (this.trsg_city == "") {
      swal("จังหวัด", "กรุณาเลือกจังหวัด", "warning");
    } else if (this.trsg_map == "") {
      swal("ลิงค์แผนที่", "กรุณากรอกลิงค์แผนที่", "warning");
    } else {
      let creds = JSON.stringify({
        url: this.urlbase,
        trsg_id: this.trsg_id,
        trsg_name: this.trsg_name,
        trsg_city: this.trsg_city,
        trsg_map: this.trsg_map,
        btnName: this.btnName
      });
      this.http
        .post(this.urlbase + "myconn/map/insert_map.php", creds, {
          responseType: "text"
        })
        .subscribe(data => {
          this.get = data;
          if (this.get == 1) {
            swal("เรียบร้อย", "เพิ่มสถานที่เรียบร้อยแล้ว", "success");
            this.router.navigate(["map"]);
          } else {
            swal("เกิดปัญหา", "ไม่สามารถเพิ่มสถานที่ได้", "error");
          }
        });
    }
  }
}
