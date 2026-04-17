import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class MyEducation extends StatelessWidget {
  const MyEducation({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        children: [
          Text('\n'),
          Image.asset(
            'assets/images/saohai.png',
            width: 150,
            height: 150,
          ),
          Text(
            '\n2016 - 2018 :',
            style: GoogleFonts.mitr(
                fontSize: 18,
                fontWeight: FontWeight.w400,
                color: Color(0xFF439224)),
          ),
          Text(
            'โรงเรียนเสาไห้วิมลวิทยานุกูล',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w300,
            ),
          ),
          Text(
            'มัธยมศึกษาตอนต้น สายวิทย์-คณิต\n',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w300,
            ),
          ),
          Image.asset(
            'assets/images/technic.png',
            width: 150,
            height: 150,
          ),
          Text(
            '\n2019 - 2021 :',
            style: GoogleFonts.mitr(
                fontSize: 18,
                fontWeight: FontWeight.w400,
                color: Color(0xFFA92929)),
          ),
          Text(
            'วิทยาลัยเทคนิคสระบุรี',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w300,
            ),
          ),
          Text(
            'ประกาศนียบัตรวิชาชีพ (ปวช.) สาขาเทคนิคคอมพิวเตอร์\n',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w300,
            ),
          ),
          Image.asset(
            'assets/images/rmutt.png',
            width: 150,
            height: 150,
          ),
          Text(
            '\n2022 - Present :',
            style: GoogleFonts.mitr(
                fontSize: 18,
                fontWeight: FontWeight.w400,
                color: Color.fromARGB(255, 211, 105, 34)),
          ),
          Text(
            'มหาวิทยาลัยเทคโนโลยีราชมงคลธัญบุรี',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w300,
            ),
          ),
          Text(
            'ปริญญาตรี คณะวิศวกรรมศาสตร์ ภาควิชาวิศวกรรมคอมพิวเตอร์\n',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w300,
            ),
          ),
        ],
      ),
    );
  }
}
