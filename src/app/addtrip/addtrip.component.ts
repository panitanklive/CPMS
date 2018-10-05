import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";
//import {NgSelectModule, NgOption} from '@ng-select/ng-select';

@Component({
  selector: "app-addtrip",
  templateUrl: "./addtrip.component.html",
  styleUrls: ["./addtrip.component.css"]
})
export class AddtripComponent implements OnInit {
  term: any;
  urlbase: string;
  employee: any[] = [{ employee_detail: "" }];
  passenger: any[] = [];
  trsg: any[] = [];
  car: any[] = [];
  carpool_id: any;
  trsg_id: any;
  trip_id: any;
  trip_start = "";
  trip_time = "";
  trip_end: string;
  btnName = "เพิ่ม";

  constructor(
    private http: HttpClient,
    private router: Router,
    private location: Location,
    public service: UrlService,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService
  ) {
    this.urlbase = service.get_url();
    this.service.nav = "car";
  }

  ngOnInit() {
    this.activatedRoute.params.subscribe(params => {
      if (!params["key"]) {
        this.router.navigate(["car"]);
      } else {
        this.carpool_id = params["key"];
        this.feed_car();
        this.feed_trsg();
      }
    });
  }

  search() {
    if (this.term.length == 5 || this.term.length == 6) {
      this.http
        .get<any[]>(
          this.urlbase +
            "myconn/addtrip/search_emp.php?employee_id=" +
            this.term
        )
        .subscribe(data => {
          this.employee = data;
          console.log(this.employee[0].employee_id)
        });
    } else {
      this.employee = [{ employee_detail: "" }];
      console.log(this.employee[0].employee_id)
    }
  }

  add(employee_detail, employee_dep, employee_id) {
    if (this.car[0].carpool_sit2 <= this.passenger.length) {
      swal("ผิดพลาด", "จำนวนที่นั่งเกินแล้ว", "error");
    } else {
      if (this.passenger.length == 0) {
        this.passenger.push({
          trip_id: "",
          employee_id: this.term,
          employee_detail: employee_detail,
          employee_dep: employee_dep,
          passenger_status: "จอง",
          passenger_tel: "",
          passenger_tel_table: ""
        });
      } else {
        var x = 0;
        for (let i = 0; i < this.passenger.length; i++) {
          if (employee_id == this.passenger[i].employee_id) {
            x++;
            swal({
              type: "warning",
              title: "ชื่อพนักงานซ้ำ",
              text: employee_detail + " อยู่ในรายการจองแล้ว"
            });
          }
        }
        if (x == 0) {
          this.passenger.push({
            employee_id: this.term,
            employee_detail: employee_detail,
            employee_dep: employee_dep,
            passenger_status: "โดยสาร",
            passenger_tel: "",
            passenger_tel_table: ""
          });
        }
      }
    }
    this.employee = [{ employee_detail: "" }];
    this.term = null;
  }

  del(i) {
    this.passenger.splice(i, 1);
  }

  feed_trsg() {
    this.http
      .get<any[]>(this.urlbase + "myconn/addtrip/feed_trsg.php")
      .subscribe(data => {
        this.trsg = data;
      });
  }

  feed_car() {
    this.http
      .get<any[]>(
        this.urlbase +
          "myconn/addtrip/feed_car.php?carpool_id=" +
          this.carpool_id
      )
      .subscribe(data => {
        this.car = data;
      });
  }

  add_trip() {
    if (this.trip_start == "") {
      swal("วันที่เดินทาง", "กรุณาเลือกวันที่เดินทาง", "warning");
    } else if (this.trip_time == "") {
      swal("เวลาเดินทาง", "กรุณากรอกเวลาเดินทาง", "warning");
    } else if (this.trip_end == "") {
      swal("วันที่กลับ", "กรุณาเลือกวันที่กลับ", "warning");
    } else if (this.trsg_id === undefined) {
      swal("สถานที่เดินทาง", "กรุณาเลือกสถานที่เดินทาง", "warning");
    } else if (this.trip_start > this.trip_end) {
      swal("ช่วงเวลาการเดินทาง", "ระบุวันที่เดินทางไม่ถูกต้อง", "warning");
    } else if (this.passenger.length == 0) {
      swal(
        "ผู้ร่วมเดินทาง",
        "กรุณาเลือกพื่นที่เดินทางอย่างน้อย 1 คน",
        "warning"
      );
    } else {
      let creds = JSON.stringify({
        url: this.urlbase,
        carpool_id: this.carpool_id,
        trip_start: this.trip_start,
        trip_time: this.trip_time,
        trip_end: this.trip_end,
        trip_sit: this.passenger.length,
        trsg_id: this.trsg_id,
        btnName: this.btnName
      });
      this.http
        .post(this.urlbase + "myconn/addtrip/insert_trip.php", creds, {
          responseType: "text"
        })
        .subscribe(data => {
          this.trip_id = data;
          if (this.trip_id == 0) {
            swal(
              "วันที่ในการจอง",
              "รอบการเดินทางซ้ำกรุณาเลือกรถใหม่",
              "warning"
            );
          } else {
            for (let i = 0; i < this.passenger.length; i++) {
              this.passenger[i].trip_id = this.trip_id;
            }
            this.save_detail();
          }
        });
    }
  }

  save_detail() {
    let creads = JSON.stringify(this.passenger);
    this.http
      .post(this.urlbase + "myconn/addtrip/add_detail.php", creads, {
        responseType: "text"
      })
      .subscribe(data => {
        this.router.navigate(["carpool"]);
        swal({
          title: "เรียบร้อยแล้ว",
          type: "question",
          html:
            "ต้องการพิมพ์ใบจองหรือไม่?, " +
            '<a href="' +
            this.urlbase +
            "\\TCPDF-master\\examples\\take_car.php?&id=" +
            this.trip_id +
            ' "target="_blank">' +
            "คลิกที่นี่" +
            "</a>",
          focusConfirm: false,
          confirmButtonAriaLabel: "ตกลง"
        });
      });
  }

  ch(data, i) {
    if (data == "จอง") {
      this.passenger[i].passenger_status = "โดยสาร";
    } else {
      this.passenger[i].passenger_status = "จอง";
    }
  }

  group_dep(employee_dep) {
    swal({
      title: "ข้อมูลเพิ่มเติม",
      type: "info",
      html: "แผนก : " + employee_dep,
      focusConfirm: false,
      confirmButtonAriaLabel: "ตกลง"
    });
  }
}
