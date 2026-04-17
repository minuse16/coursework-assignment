package HW2;

public class Person {
    private String idNumber;
    private String fullName;
    private String gender;

    public Person(String idNumber, String fullName, String gender) {
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

    public String getIdNumber() {
        return idNumber;
    }

    public String getFullName() {
        return fullName;
    }

    public String getGender() {
        return gender;
    }
}
