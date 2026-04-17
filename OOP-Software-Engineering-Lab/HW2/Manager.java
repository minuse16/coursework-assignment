package HW2;

public class Manager extends Person {
    private String password;

    public Manager(String idNumber, String fullName, String gender, String password) {
        super(idNumber, fullName, gender);
        if (password.length() != 4) {
            throw new IllegalArgumentException("Password must have 4 digits.");
        }
        this.password = password;
    }

    public boolean validatePassword(String password) {
        return this.password.equals(password);
    }
}
