import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class MySkill extends StatelessWidget {
  const MySkill({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        children: [
          Text(
            '\nSoft Skills :',
            style: GoogleFonts.mitr(
                fontSize: 19,
                fontWeight: FontWeight.bold,
                color: Color(0xFF873FA8)),
          ),
          Text(
            '- มีทักษะในการทำงานร่วมกับผู้อื่น\n- มีทักษะในการทำงานได้ด้วยตนเอง\n- มีความสามารถในการปฏิบัติตามคำสั่ง',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w300,
            ),
          ),
          Text(
            '\nLanguage :',
            style: GoogleFonts.mitr(
                fontSize: 19,
                fontWeight: FontWeight.bold,
                color: Color(0xFF873FA8)),
          ),
          Text(
            '- Thai\n- English\n- Korean\n',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w300,
            ),
          )
        ],
      ),
    );
  }
}
