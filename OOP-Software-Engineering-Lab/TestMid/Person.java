public class Person {
    String idNumber;
    String fullName;
    String gender;

    Person(String idNumber, String fullName, String gender) {
        if (idNumber.length() != 13) {
            throw new IllegalArgumentException("ID Number must have 13 digits.");
        }
        if (gender == null || (!gender.equalsIgnoreCase("Male") && !gender.equalsIgnoreCase("Female"))) {
            throw new IllegalArgumentException("Gender must be 'Male' or 'Female'.");
        }
        this.idNumber = idNumber;
        this.fullName = fullName;
        this.gender = gender;
    }

    String getIdNumber() {
        return idNumber;
    }

    String getFullName() {
        return fullName;
    }

    String getGender() {
        return gender;
    }
}
