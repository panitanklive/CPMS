import { Component, OnInit, ViewChild } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from "@angular/router";
import swal from "sweetalert2";
import { CookieService } from "ngx-cookie-service";
import { UrlService } from "../url.service";
import { Router } from "@angular/router";
import { Location } from "@angular/common";

@Component({
  selector: "app-editround",
  templateUrl: "./editround.component.html",
  styleUrls: ["./editround.component.css"]
})
export class EditroundComponent implements OnInit {
  urlbase: string;
  round: any[];
  trip_id: string;
  passenger: any[];
  term: string;
  employee: any[] = [{ employee_detail: "" }];
  trsg: any[];
  car: any;
  car_if: any[];

  constructor(
    private http: HttpClient,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService,
    public service: UrlService,
    private router: Router,
    private location: Location
  ) {
    this.urlbase = service.get_url();
  }

  ngOnInit() {
    this.activatedRoute.params.subscribe(params => {
      if (!params["key"]) {
      } else {
        this.trip_id = params["key"];
        this.veiw_round();
        this.feed_trsg();
        this.feed_passenger();
      }
    });
  }

  feed_car_if() {
    if (
      this.round[0].trip_start > this.round[0].trip_end ||
      this.round[0].trip_start == "" ||
      this.round[0].trip_end == ""
    ) {
      swal(
        "วันที่ในการค้นหา",
        "กรุณากรอกวันที่ในการค้นหาให้ถูกต้อง ",
        "warning"
      );
    } else {
      this.http
        .get<any[]>(
          this.urlbase +
            "myconn/car/feed_car_if.php?trip_start=" +
            this.round[0].trip_start +
            "&&trip_end=" +
            this.round[0].trip_end
        )
        .subscribe(data => {
          this.car_if = data;
        });
    }
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
        });
    } else {
      this.employee = [{ employee_detail: "" }];
    }
  }

  veiw_round() {
    this.http
      .get<any[]>(
        this.urlbase + "myconn/round/veiw_round.php?trip_id=" + this.trip_id
      )
      .subscribe(data => {
        this.round = data;
        this.feed_car_if();
      });
  }

  feed_passenger() {
    this.http
      .get<any[]>(
        this.urlbase + "myconn/round/feed_passenger.php?trip_id=" + this.trip_id
      )
      .subscribe(data => {
        this.passenger = data;
        this.feed_car();
      });
  }

  ch(data, i) {
    if (data == "จอง") {
      this.passenger[i].passenger_status = "โดยสาร";
    } else {
      this.passenger[i].passenger_status = "จอง";
    }
  }

  add(employee_detail, employee_dep, employee_id) {
    if (this.car[0].carpool_sit2 <= this.passenger.length) {
      swal("ผิดพลาด", "จำนวนที่นั่งเกินแล้ว", "error");
    } else {
      if (this.passenger.length == 0) {
        this.passenger.push({
          trip_id: this.trip_id,
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
            trip_id: this.trip_id,
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

  feed_car() {
    this.http
      .get<any[]>(
        this.urlbase +
          "myconn/addtrip/feed_car.php?carpool_id=" +
          this.round[0].carpool_id
      )
      .subscribe(data => {
        this.car = data;
      });
  }

  edit_trip() {
    if (this.round[0].trip_start == "") {
      swal("วันที่เดินทาง", "กรุณาเลือกวันที่เดินทาง", "warning");
    } else if (this.round[0].trip_time == "") {
      swal("เวลาเดินทาง", "กรุณากรอกเวลาเดินทาง", "warning");
    } else if (this.round[0].trip_end == "") {
      swal("วันที่กลับ", "กรุณาเลือกวันที่กลับ", "warning");
    } else if (this.round[0].trsg_id == "") {
      swal("สถานที่เดินทาง", "กรุณาเลือกสถานที่เดินทาง", "warning");
    } else if (this.round[0].trip_start > this.round[0].trip_end) {
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
        carpool_id: this.round[0].carpool_id,
        trip_id: this.trip_id,
        trip_start: this.round[0].trip_start,
        trip_time: this.round[0].trip_time,
        trip_end: this.round[0].trip_end,
        trip_sit: this.passenger.length,
        trsg_id: this.round[0].trsg_id,
        btnName: "แก้ไข"
      });
      this.http
        .post(this.urlbase + "myconn/round/edit_trip.php", creds, {
          responseType: "text"
        })
        .subscribe(data => {
          this.save_detail();
        });
    }
  }

  save_detail() {
    let creads = JSON.stringify(this.passenger);
    this.http
      .post(this.urlbase + "myconn/round/add_detail.php", creads, {
        responseType: "text"
      })
      .subscribe(data => {
        this.router.navigate(["give"]);
        swal({
          title: "เรียบร้อยแล้ว",
          type: "success",
          html: "แก้ไขการจองเรียบร้อยแล้ว",
          focusConfirm: false,
          confirmButtonAriaLabel: "ตกลง"
        });
      });
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
