public class Manager extends Person {
    String password;
    double btcTothbRate = 0;

    Manager(String idNumber, String fullName, String gender, String password) {
        super(idNumber, fullName, gender);
        if (password.length() != 4) {
            throw new IllegalArgumentException("Password must have 4 digits.");
        }
        this.password = password;
    }

    boolean validatePassword(String password) {
        return this.password.equals(password);
    }

    void setBtcToThbRate(double rate) {
        this.btcTothbRate = rate;
        System.out.println("BTC rate : " + rate);
    }

    double getBtcToThbRate() {
        return this.btcTothbRate;
    }
}
